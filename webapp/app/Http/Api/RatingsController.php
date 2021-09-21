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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Throwable;

class RatingsController extends ApiController
{
    private RatingRepositoryInterface $ratingRepository;
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(RatingRepositoryInterface $ratingRepository,
                                ReviewRepositoryInterface $reviewRepository,
                                LogServiceInterface       $logger)
    {
        parent::__construct($logger);

        $this->ratingRepository = $ratingRepository;
        $this->reviewRepository = $reviewRepository;
    }

    public function list(): JsonResponse
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

    public function add(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {

                    $exists = $this->ratingRepository->exists($request->get('place_id'), $user->id);

                    if (!isset($exists)) {
                        $rating = new Rating();
                        $rating->rating = $request->get('rating');
                        $rating->user_id = $user->id;
                        $rating->place_id = $request->get('place_id');
                        $rating->published = 1;
                        $rating->deleted = 0;

                        $this->ratingRepository->save($rating);

                        $review = new Review();
                        $review->review = '';

                        if ($request->has('review'))
                            $review->review = Str::limit($request->get('review'), 250);

                        $review->rating_id = $rating->id;
                        $review->user_id = $rating->user_id;
                        $review->place_id = $rating->place_id;
                        $review->show = 1;
                        $review->published = 1;
                        $review->deleted = 0;

                        $this->reviewRepository->save($review);
                    }
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function remove($rating_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $review = $this->reviewRepository->existsByRating($rating_id);

                    if (isset($review))
                        $this->reviewRepository->delete($review->id);

                    $this->ratingRepository->delete($rating_id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
