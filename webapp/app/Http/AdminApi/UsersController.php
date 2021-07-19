<?php


namespace App\Http\AdminApi;

use App\Http\AdminApi\Base\AdminApiController;
use App\Models\UserToPlace;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserToPlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UsersController extends AdminApiController
{
    private UserRepositoryInterface $repository;
    private UserToPlaceRepositoryInterface $userToPlaceRepository;

    public function __construct(UserRepositoryInterface $repository,
                                UserToPlaceRepositoryInterface $userToPlaceRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->userToPlaceRepository = $userToPlaceRepository;
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
