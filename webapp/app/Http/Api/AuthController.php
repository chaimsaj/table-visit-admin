<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\AppModels\TokenModel;
use App\Core\ApiCodeEnum;
use App\Core\AuthModeEnum;
use App\Core\BaseEnum;
use App\Core\GenderEnum;
use App\Core\MediaSizeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\User;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends ApiController
{
    private UserProfileRepositoryInterface $userProfileRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(UserProfileRepositoryInterface $userProfileRepository,
                                UserRepositoryInterface        $userRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->userProfileRepository = $userProfileRepository;
        $this->userRepository = $userRepository;
    }

    public function sign_in(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            if (Auth::user()->user_type_id != UserTypeEnum::Admin
                && Auth::user()->user_type_id != UserTypeEnum::PlaceAdmin) {
                $auth_token = $request->user()->createToken('auth_token');

                $token = new TokenModel();
                $token->setAccessToken($auth_token->plainTextToken);
                $token->setTokenType('Bearer');

                $response->setData($token);
            } else
                $response->setError("Invalid user or password..");
        } else
            $response->setError("Invalid user or password..");

        return response()->json($response);
    }

    public function sign_out(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        if (Auth::check()) {
            $token = Auth::user()->currentAccessToken();
            $token->delete();
        } else
            $response->setError();

        return response()->json($response);

        // Revoke all tokens...
        //$user->tokens()->delete();

        // Revoke the token that was used to authenticate the current request...
        //$request->user()->currentAccessToken()->delete();

        // Revoke a specific token...
        //$user->tokens()->where('id', $tokenId)->delete();

    }

    public function sign_up(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            $error = 'An error occurred. Please try again later.';

            if ($validator->getMessageBag()->count() != 0)
                $error = $validator->getMessageBag()->first();

            $response->setError($error);
            return response()->json($response);
        }

        try {
            User::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'auth_mode' => AuthModeEnum::Basic,
                'user_type_id' => UserTypeEnum::Customer,
                'gender' => GenderEnum::Undefined
            ]);
        } catch (Throwable $ex) {
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function logged_user(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        if (Auth::check()) {
            $user = $this->userRepository->find(Auth::user()->id);

            if (isset($user)) {
                if (isset($user->dob))
                    $user->dob = DateTime::createFromFormat('Y-m-d', $user->dob)->format('Y-m-d');

                $user->avatar = MediaHelper::getImageUrl(MediaHelper::getUsersPath(), $user->avatar);

                $profile = $this->userProfileRepository->loadByUser($user->id);

                if (isset($profile))
                    $user->profile = $profile;

                $response->setData($user);
            }
        } else
            $response->setError();

        return response()->json($response);
    }

    public function valid_user(): JsonResponse
    {
        $response = new ApiModel();

        if (Auth::check()) {
            $response->setSuccess();
        } else
            $response->setError();

        return response()->json($response);
    }
}
