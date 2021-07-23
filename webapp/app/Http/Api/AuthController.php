<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\AppModels\TokenModel;
use App\Core\ApiCodeEnum;
use App\Core\AuthModeEnum;
use App\Core\BaseEnum;
use App\Core\UserTypeEnum;
use App\Http\Api\Base\ApiController;
use App\Models\User;
use App\Repositories\CityRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends ApiController
{
    public function __construct(LogServiceInterface $logger)
    {
        parent::__construct($logger);
    }

    public function sign_in(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $auth_token = $request->user()->createToken('auth_token');

            $token = new TokenModel();
            $token->setAccessToken($auth_token->plainTextToken);
            $token->setTokenType('Bearer');

            $response->setData($token);
        } else
            $response->setError();

        return response()->json($response);
    }

    public function sign_out(Request $request): JsonResponse
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

        $data = request()->json()->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            $response->setError($validator->getMessageBag());
            return response()->json($response);
        }

        try {
            User::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'auth_mode' => AuthModeEnum::Basic,
                'user_type_id' => UserTypeEnum::Guest,
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
            $user = Auth::user();

            if (isset($user->dob))
                $user->dob = DateTime::createFromFormat('Y-m-d', $user->dob)->format('d-m-Y');

            $response->setData($user);
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
