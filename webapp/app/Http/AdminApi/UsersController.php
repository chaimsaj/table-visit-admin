<?php


namespace App\Http\AdminApi;

use App\Http\AdminApi\Base\AdminApiController;
use Illuminate\Http\JsonResponse;

class UsersController extends AdminApiController
{
    public function load_users(): JsonResponse
    {
        return response()->json($this->userService->actives());
    }

    public function load_places(): JsonResponse
    {
        $userToPlaces = $this->userToPlaceService->published();

        return response()->json($userToPlaces);
    }
}
