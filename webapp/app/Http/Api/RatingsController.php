<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\MediaSizeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Favorite;
use App\Models\Rating;
use App\Repositories\FavoriteRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\RatingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class RatingsController extends ApiController
{
    private RatingRepositoryInterface $ratingRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository,
                                LogServiceInterface       $logger)
    {
        parent::__construct($logger);

        $this->ratingRepository = $ratingRepository;
    }

    public function user_ratings(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->ratingRepository->userRatings($user->id);
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

                    $exists = $this->ratingRepository->exists($place_id, $user->id);

                    if (!isset($exists)) {
                        $db = new Rating();
                        $db->rating = 0;
                        $db->user_id = $user->id;
                        $db->place_id = $place_id;
                        $db->published = 1;
                        $db->deleted = 0;

                        $this->ratingRepository->save($db);
                    }
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function remove($rel_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $this->ratingRepository->delete($rel_id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
