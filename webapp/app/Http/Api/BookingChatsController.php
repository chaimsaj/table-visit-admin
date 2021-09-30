<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingChatRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingChatsController extends ApiController
{
    private BookingChatRepositoryInterface $bookingChatRepository;

    public function __construct(BookingChatRepositoryInterface $bookingChatRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->bookingChatRepository = $bookingChatRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->bookingChatRepository->published();
                    $response->setData($query);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
