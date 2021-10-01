<?php

namespace App\Http\Api\Staff;

use App\AppModels\ApiModel;
use App\Core\MediaSizeEnum;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class BookingsController extends ApiController
{
    private BookingRepositoryInterface $bookingRepository;
    private TableRepositoryInterface $tableRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository,
                                TableRepositoryInterface   $tableRepository,
                                UserRepositoryInterface    $userRepository,
                                LogServiceInterface        $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
        $this->tableRepository = $tableRepository;
        $this->userRepository = $userRepository;
    }

    public function search(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                $query = $this->bookingRepository->staffSearch($request->get('word'), $user->place_id);

                foreach ($query as $item) {
                    $table = $this->tableRepository->find($item->table_id);
                    $customer = $this->userRepository->find($item->user_id);

                    if (isset($table) && isset($customer)) {
                        $item->table = $table;
                        $item->customer_name = $customer->name;
                        $item->customer_last_name = $customer->last_name;
                        $item->customer_avatar = MediaHelper::getImageUrl($customer->avatar, MediaSizeEnum::medium);
                    }
                }

                $response->setData($query);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
