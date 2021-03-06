<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\LanguageEnum;
use App\Core\MediaSizeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Place;
use App\Models\PlaceFeature;
use App\Repositories\FavoriteRepositoryInterface;
use App\Repositories\PlaceDetailRepositoryInterface;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Repositories\RatingRepositoryInterface;
use App\Services\LogServiceInterface;
use Geocoder\Laravel\Facades\Geocoder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Throwable;

class PlacesController extends ApiController
{
    private PlaceRepositoryInterface $placeRepository;
    private PlaceDetailRepositoryInterface $placeDetailRepository;
    private PlaceTypeRepositoryInterface $placeTypeRepository;
    private PlaceFeatureRepositoryInterface $placeFeatureRepository;
    private PlaceMusicRepositoryInterface $placeMusicRepository;
    private FavoriteRepositoryInterface $favoriteRepository;
    private RatingRepositoryInterface $ratingRepository;

    public function __construct(PlaceRepositoryInterface        $placeRepository,
                                PlaceDetailRepositoryInterface  $placeDetailRepository,
                                PlaceTypeRepositoryInterface    $placeTypeRepository,
                                PlaceFeatureRepositoryInterface $placeFeatureRepository,
                                PlaceMusicRepositoryInterface   $placeMusicRepository,
                                FavoriteRepositoryInterface     $favoriteRepository,
                                RatingRepositoryInterface       $ratingRepository,
                                LogServiceInterface             $logger)
    {
        parent::__construct($logger);

        $this->placeRepository = $placeRepository;
        $this->placeDetailRepository = $placeDetailRepository;
        $this->placeTypeRepository = $placeTypeRepository;
        $this->placeFeatureRepository = $placeFeatureRepository;
        $this->placeMusicRepository = $placeMusicRepository;
        $this->favoriteRepository = $favoriteRepository;
        $this->ratingRepository = $ratingRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->placeRepository->published();
            $user_favorites = new Collection;

            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $user_favorites = $this->favoriteRepository->userFavorites($user->id);
                }
            }

            foreach ($query as $item) {
                $has = $user_favorites->firstWhere('place_id', '=', $item->id);
                $item->is_favorite = isset($has);
                $item->image_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $item->image_path, MediaSizeEnum::medium);
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
            $user_favorites = new Collection;

            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $user_favorites = $this->favoriteRepository->userFavorites($user->id);
                }
            }

            $language = LanguageEnum::English;

            $data = $this->load_place($query);
            $data->detail = $this->detail($data->id, $language);

            $has = $user_favorites->firstWhere('place_id', '=', $data->id);
            $data->is_favorite = isset($has);

            if (isset($data->detail))
                $data->detail->short_detail = AppHelper::truncateString(strip_tags($data->detail->detail), 145);

            $response->setData($data);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function near_by_city(int $city_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $data = new Collection;

        try {
            if (Auth::check()) {
                $query = $this->placeRepository->byCity($city_id, 1000);

                foreach ($query as $item) {
                    $data_item = $this->load_place($item);
                    $data->add($data_item);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        $response->setData($data);

        return response()->json($response);
    }

    public function featured_by_city(int $city_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $data = new Collection;

        try {
            if (Auth::check()) {
                $query = $this->placeRepository->featuredByCity($city_id);

                foreach ($query as $item) {
                    $data_item = $this->load_place($item);
                    $data->add($data_item);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        $response->setData($data);

        return response()->json($response);
    }

    public function featured(int $top = 25): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $data = new Collection;

        try {
            $query = $this->placeRepository->featured($top);

            $user_favorites = new Collection;

            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $user_favorites = $this->favoriteRepository->userFavorites($user->id);
                }
            }

            foreach ($query as $item) {
                $has = $user_favorites->firstWhere('place_id', '=', $item->id);
                $data_item = $this->load_place($item);
                $data_item->is_favorite = isset($has);
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
            if (Auth::check()) {
                $query = $this->placeRepository->near($top);

                foreach ($query as $item) {
                    $data_item = $this->load_place($item);
                    $data->add($data_item);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        $response->setData($data);

        return response()->json($response);
    }

    public function search(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $data = new Collection;

        try {
            if (Auth::check()) {
                $word = "";
                $city_id = 0;

                $request_data = $request->json()->all();

                if (isset($request_data)) {
                    if (isset($request_data['word']))
                        $word = $request_data['word'];

                    if (isset($request_data['city_id']))
                        $city_id = intval($request_data['city_id']);
                }

                $query = $this->placeRepository->search($word, $city_id);

                $user_favorites = new Collection;

                if (Auth::check()) {
                    $user = Auth::user();

                    if (isset($user)) {
                        $user_favorites = $this->favoriteRepository->userFavorites($user->id);
                    }
                }

                foreach ($query as $item) {
                    $has = $user_favorites->firstWhere('place_id', '=', $item->id);

                    $data_item = $this->load_place($item);
                    $data_item->is_favorite = isset($has);
                    $data->add($data_item);
                }
            }
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

        $item->image_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $image, MediaSizeEnum::medium);
        $item->large_image_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $image, MediaSizeEnum::large);
        $item->floor_plan_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $item->floor_plan_path, MediaSizeEnum::large);
        $item->food_menu_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $item->food_menu_path, MediaSizeEnum::large);

        $ratings = $this->ratingRepository->ratingByPlace($item->id);

        $item->place_rating_count = $ratings->count();
        $item->place_rating_avg = round($ratings->avg('rating'), 2);

        if ($item->place_rating_count == 0)
            $item->place_rating_avg = 0;

        if (!isset($item->open_at))
            $item->open_at = 0;

        if (!isset($item->close_at))
            $item->close_at = 0;

        $item->place_types = $this->place_types($item->id);

        if ($item->place_types->count() > 0)
            $item->place_type_name = $item->place_types[0]->name;
        else
            $item->place_type_name = "Venue";

        $item->place_features = $this->place_features($item->id);
        $item->place_music = $this->place_music($item->id);

        if (!isset($item->location_lat) || !isset($item->location_lng))
            $this->geocode($item->id);

        return $item;
    }

    private function geocode(int $id)
    {
        try {
            $place = $this->placeRepository->find($id);

            if (isset($place)) {
                $geocodes = Geocoder::geocode($place->address)->get();

                if ($geocodes->count() > 0) {
                    $geocode = $geocodes->first();

                    if (isset($geocode)) {
                        $place->location_lat = $geocode->getCoordinates()->getLatitude();
                        $place->location_lng = $geocode->getCoordinates()->getLongitude();

                        $this->placeRepository->save($place);
                    }
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }
    }

    #end region
}
