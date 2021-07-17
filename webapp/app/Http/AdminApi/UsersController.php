<?php


namespace App\Http\AdminApi;

use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class UsersController extends AdminApiController
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function load_users(): JsonResponse
    {
        return response()->json($this->repository->actives());
    }

    public function load_places(): JsonResponse
    {
        $userToPlaces = $this->repository->published();

        return response()->json($userToPlaces);
    }
}
