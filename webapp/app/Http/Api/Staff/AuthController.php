<?php

namespace App\Http\Api\Staff;

use App\AppModels\ApiModel;
use App\AppModels\TokenModel;
use App\Core\MediaSizeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Services\LogServiceInterface;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

        try {
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                if (Auth::user()->user_type_id != UserTypeEnum::Customer
                    && Auth::user()->user_type_id != UserTypeEnum::Admin
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
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function sign_out(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $token = Auth::user()->currentAccessToken();
                $token->delete();
            } else
                $response->setError();

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function logged_user(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user->dob))
                    $user->dob = DateTime::createFromFormat('Y-m-d', $user->dob)->format('d-m-Y');

                $user->avatar = MediaHelper::getImageUrl(MediaHelper::getUsersPath(), $user->avatar, MediaSizeEnum::medium);

                $response->setData($user);
            } else
                $response->setError();
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function valid_user(): JsonResponse
    {
        $response = new ApiModel();

        try {

            if (Auth::check()) {
                $response->setSuccess();
            } else
                $response->setError();

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
