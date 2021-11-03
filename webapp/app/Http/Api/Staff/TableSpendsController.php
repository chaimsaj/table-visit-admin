<?php

namespace App\Http\Api\Staff;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Models\TableSpend;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableSpendRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class TableSpendsController extends ApiController
{
    private TableSpendRepositoryInterface $tableSpendRepository;
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(TableSpendRepositoryInterface $tableSpendRepository,
                                ServiceRepositoryInterface    $serviceRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->tableSpendRepository = $tableSpendRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function list(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->tableSpendRepository->loadByBooking(intval($request->get('booking_id')));

                    foreach ($query as $item) {
                        $service = $this->serviceRepository->find($item->service_id);

                        if (isset($service))
                            $item->service_name = $service->name;
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
}
