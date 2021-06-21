<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\ApiCodeEnum;
use App\Core\AuthModeEnum;
use App\Core\BaseEnum;
use App\Core\UserTypeEnum;
use App\Http\Api\Base\ApiController;
use App\Models\User;
use App\Services\CountryServiceInterface;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends ApiController
{
    public function sign_in(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setCode(ApiCodeEnum::Error);
        $response->setMessage(ApiCodeEnum::toString(ApiCodeEnum::Error));

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            $token = $request->user()->createToken('auth_token');

            $response->setToken($token->plainTextToken);
            $response->setCode(ApiCodeEnum::Ok);
            $response->setMessage(ApiCodeEnum::toString(ApiCodeEnum::Ok));
        }

        return response()->json($response);
    }

    public function sign_out(Request $request): JsonResponse
    {
        if (Auth::check()) {
            $request->user()->currentAccessToken()->delete();
        }

        $response = new ApiModel();
        $response->setCode(ApiCodeEnum::Ok);
        $response->setMessage(ApiCodeEnum::toString(ApiCodeEnum::Ok));

        return response()->json($response);
    }

    public function sign_up(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setCode(ApiCodeEnum::Ok);
        $response->setCode(ApiCodeEnum::toString(ApiCodeEnum::Ok));

        $data = request()->json()->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if ($validator->fails()) {
            $response->setData($validator->getMessageBag());
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
        } catch (Exception $exc) {
            $response->setCode(ApiCodeEnum::Error);
            $response->setMessage(ApiCodeEnum::toString(ApiCodeEnum::Error));
            $response->setData($exc);
        }

        return response()->json($response);
    }
}
