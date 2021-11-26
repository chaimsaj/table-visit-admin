<?php


namespace App\Http\AdminApi;

use App\AppModels\ApiModel;
use App\AppModels\DatatableModel;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\CommissionRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ReportsController extends AdminApiController
{
    private CommissionRepositoryInterface $commissionRepository;
    private BookingRepositoryInterface $bookingRepository;

    public function __construct(CommissionRepositoryInterface $commissionRepository,
                                BookingRepositoryInterface    $bookingRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->commissionRepository = $commissionRepository;
        $this->bookingRepository = $bookingRepository;
    }

    public function table_spends(Request $request): JsonResponse
    {
        $place_id = intval($request->get('place_id'));

        $response = new DatatableModel();

        try {

            $date_from = today();
            $date_to = today();

            if (!empty($request->get('date_from')) && !empty($request->get('date_to'))) {
                $date_from = DateTime::createFromFormat('m-d-Y', $request->get('date_from'));
                $date_to = DateTime::createFromFormat('m-d-Y', $request->get('date_to'));
            }

            $query = $this->bookingRepository->tableSpendsReport($date_from, $date_to, $place_id);

            foreach ($query as $item) {
                $item->book_date_data = DateTime::createFromFormat('Y-m-d H:i:s', $item->book_date)->format('m-d-Y');
            }

            $response->setDraw((int)$request->get('draw'));
            if (isset($query)) {
                $response->setRecordsFiltered($query->count());
                $response->setRecordsTotal($query->count());
                $response->setData($query);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function commissions(Request $request): JsonResponse
    {
        $place_id = intval($request->get('place_id'));

        $response = new DatatableModel();

        try {

            $date_from = today();
            $date_to = today();

            if (!empty($request->get('date_from')) && !empty($request->get('date_to'))) {
                $date_from = DateTime::createFromFormat('m-d-Y', $request->get('date_from'));
                $date_to = DateTime::createFromFormat('m-d-Y', $request->get('date_to'));
            }

            $query = $this->bookingRepository->tableSpendsReport($date_from, $date_to, $place_id);

            foreach ($query as $item) {
                $item->book_date_data = DateTime::createFromFormat('Y-m-d H:i:s', $item->book_date)->format('m-d-Y');
                $item->commission_amount = 0;

                $commission = $this->commissionRepository->loadByPlace($item->place_id);

                if (!isset($commission))
                    $commission = $this->commissionRepository->loadByPlace(0);

                if (isset($commission)) {
                    $amount = $item->spent_total_amount > $item->total_amount ? $item->spent_total_amount : $item->total_amount;
                    $item->commission_amount = round(($amount / 100) * $commission->percentage, 2);
                }
            }

            $response->setDraw((int)$request->get('draw'));
            if (isset($query)) {
                $response->setRecordsFiltered($query->count());
                $response->setRecordsTotal($query->count());
                $response->setData($query);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
