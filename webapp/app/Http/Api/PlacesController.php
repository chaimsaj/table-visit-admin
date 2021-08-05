<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\LanguageEnum;
use App\Core\MediaSizeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Place;
use App\Models\PlaceFeature;
use App\Repositories\PlaceDetailRepositoryInterface;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Throwable;

class PlacesController extends ApiController
{
    private PlaceRepositoryInterface $placeRepository;
    private PlaceDetailRepositoryInterface $placeDetailRepository;
    private PlaceTypeRepositoryInterface $placeTypeRepository;
    private PlaceFeatureRepositoryInterface $placeFeatureRepository;
    private PlaceMusicRepositoryInterface $placeMusicRepository;

    public function __construct(PlaceRepositoryInterface        $placeRepository,
                                PlaceDetailRepositoryInterface  $placeDetailRepository,
                                PlaceTypeRepositoryInterface    $placeTypeRepository,
                                PlaceFeatureRepositoryInterface $placeFeatureRepository,
                                PlaceMusicRepositoryInterface   $placeMusicRepository,
                                LogServiceInterface             $logger)
    {
        parent::__construct($logger);

        $this->placeRepository = $placeRepository;
        $this->placeDetailRepository = $placeDetailRepository;
        $this->placeTypeRepository = $placeTypeRepository;
        $this->placeFeatureRepository = $placeFeatureRepository;
        $this->placeMusicRepository = $placeMusicRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeRepository->published();

            foreach ($query as $item) {
                $item->image_path = MediaHelper::getImageUrl($item->image_path, MediaSizeEnum::medium);
            }

            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeRepository->find($id);

            $language = LanguageEnum::English;

            $data = $this->load_place($query);
            $data->detail = $this->detail($data->id, $language);

            $response->setData($data);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function list_by_city(int $city_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeRepository->publishedByCity($city_id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function featured(int $top = 25): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $data = new Collection;

        try {
            $query = $this->placeRepository->featured($top);

            foreach ($query as $item) {
                $data_item = $this->load_place($item);
                $data->add($data_item);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        $response->setData($data);

        return response()->json($response);
    }

    public function near(int $top = 25): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $data = new Collection;

        try {
            $query = $this->placeRepository->near($top);

            foreach ($query as $item) {
                $data_item = $this->load_place($item);
                $data->add($data_item);
            }

            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        $response->setData($data);

        return response()->json($response);
    }

    #region

    private function detail(int $place_id, int $language_id): ?Model
    {
        try {
            $data = $this->placeDetailRepository->loadBy($place_id, $language_id);

            if (isset($data))
                return $data;

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return null;
    }

    private function place_types(int $place_id): ?Collection
    {
        try {
            $data = $this->placeTypeRepository->shown($place_id);

            if (isset($data))
                return $data;

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return null;
    }

    private function place_features(int $place_id): ?Collection
    {
        try {
            $data = $this->placeFeatureRepository->shown($place_id);

            if (isset($data))
                return $data;

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return null;
    }

    private function place_music(int $place_id): ?Collection
    {
        try {
            $data = $this->placeMusicRepository->shown($place_id);

            if (isset($data))
                return $data;

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return null;
    }

    private function load_place(Model $item): Model
    {
        $image = $item->image_path;
        
        $item->image_path = MediaHelper::getImageUrl($image, MediaSizeEnum::medium);
        $item->large_image_path = MediaHelper::getImageUrl($image, MediaSizeEnum::large);
        $item->floor_plan_path = MediaHelper::getImageUrl($item->floor_plan_path, MediaSizeEnum::medium);
        $item->food_menu_path = MediaHelper::getImageUrl($item->food_menu_path, MediaSizeEnum::medium);

        $item->place_rating_count = rand(0, 100);
        $item->place_rating_avg = rand(1, 5);

        $item->place_types = $this->place_types($item->id);

        if ($item->place_types->count() > 0)
            $item->place_type_name = $item->place_types[0]->name;
        else
            $item->place_type_name = "Venue";

        $item->place_features = $this->place_features($item->id);
        $item->place_music = $this->place_music($item->id);

        return $item;
    }

    #end region
}
