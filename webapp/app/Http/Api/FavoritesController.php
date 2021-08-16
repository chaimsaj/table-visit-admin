<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\FavoriteRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class FavoritesController extends ApiController
{
    private FavoriteRepositoryInterface $favoriteRepository;
    private PlaceRepositoryInterface $placeRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository,
                                PlaceRepositoryInterface    $placeRepository,
                                UserRepositoryInterface     $userRepository,
                                LogServiceInterface         $logger)
    {
        parent::__construct($logger);

        $this->favoriteRepository = $favoriteRepository;
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $user = Auth::user();


        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function add($place_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $user = Auth::user();


        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function remove($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
