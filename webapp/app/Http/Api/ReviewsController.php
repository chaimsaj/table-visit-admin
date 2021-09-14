<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\MediaSizeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\Favorite;
use App\Models\Rating;
use App\Models\Review;
use App\Repositories\FavoriteRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\RatingRepositoryInterface;
use App\Repositories\ReviewRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ReviewsController extends ApiController
{
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository,
                                LogServiceInterface       $logger)
    {
        parent::__construct($logger);

        $this->reviewRepository = $reviewRepository;
    }

    public function user_reviews(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->reviewRepository->userReviews($user->id);
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

                    $exists = $this->reviewRepository->exists($place_id, $user->id);

                    if (!isset($exists)) {
                        $db = new Review();
                        $db->rating_id = 0;
                        $db->review = '';
                        $db->user_id = $user->id;
                        $db->place_id = $place_id;
                        $db->published = 1;
                        $db->deleted = 0;

                        $this->reviewRepository->save($db);
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
                    $this->reviewRepository->delete($rel_id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
