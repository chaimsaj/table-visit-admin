<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\AppModels\SearchFilterModel;
use App\Core\ApiCodeEnum;
use App\Http\Api\Base\ApiController;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Repositories\UserSettingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class SearchController extends ApiController
{
    private PlaceTypeRepositoryInterface $placeTypeRepository;
    private PlaceFeatureRepositoryInterface $placeFeatureRepository;
    private PlaceMusicRepositoryInterface $placeMusicRepository;

    public function __construct(PlaceTypeRepositoryInterface    $placeTypeRepository,
                                PlaceFeatureRepositoryInterface $placeFeatureRepository,
                                PlaceMusicRepositoryInterface   $placeMusicRepository,
                                LogServiceInterface             $logger)
    {
        parent::__construct($logger);

        $this->placeTypeRepository = $placeTypeRepository;
        $this->placeFeatureRepository = $placeFeatureRepository;
        $this->placeMusicRepository = $placeMusicRepository;
    }

    public function filters(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $place_types = $this->placeTypeRepository->published();
            $place_features = $this->placeFeatureRepository->published();
            $place_music = $this->placeMusicRepository->published();

            $filters = new SearchFilterModel();
            $filters->setPlaceTypes($place_types);
            $filters->setPlaceFeatures($place_features);
            $filters->setPlaceMusic($place_music);

            $response->setData($filters);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
