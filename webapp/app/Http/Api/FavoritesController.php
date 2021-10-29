<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\MediaSizeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Favorite;
use App\Repositories\FavoriteRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\RatingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class FavoritesController extends ApiController
{
    private FavoriteRepositoryInterface $favoriteRepository;
    private PlaceRepositoryInterface $placeRepository;
    private RatingRepositoryInterface $ratingRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository,
                                PlaceRepositoryInterface    $placeRepository,
                                RatingRepositoryInterface   $ratingRepository,
                                LogServiceInterface         $logger)
    {
        parent::__construct($logger);

        $this->favoriteRepository = $favoriteRepository;
        $this->placeRepository = $placeRepository;
        $this->ratingRepository = $ratingRepository;
    }

    public function user_favorites(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->favoriteRepository->userFavorites($user->id);
                    $response->setData($query);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->placeRepository->favorites($user->id);
                    foreach ($query as $item) {
                        $ratings = $this->ratingRepository->ratingByPlace($item->id);

                        $item->place_rating_count = $ratings->count();
                        $item->place_rating_avg = round($ratings->avg('rating'), 2);

                        if ($item->place_rating_count == 0)
                            $item->place_rating_avg = 0;

                        if (!isset($item->open_at))
                            $item->open_at = 0;

                        if (!isset($item->close_at))
                            $item->close_at = 0;

                        $item->image_path = MediaHelper::getImageUrl(MediaHelper::getPlacesPath(), $item->image_path, MediaSizeEnum::medium);
                    }
                    $response->setData($query);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function add($place_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {

                    $exists = $this->favoriteRepository->exists($place_id, $user->id);

                    if (!isset($exists)) {
                        $db = new Favorite();
                        $db->user_id = $user->id;
                        $db->place_id = $place_id;
                        $db->published = 1;
                        $db->deleted = 0;

                        $this->favoriteRepository->save($db);
                    }
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function remove($favorite_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $this->favoriteRepository->delete($favorite_id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
