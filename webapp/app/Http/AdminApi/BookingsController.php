<?php


namespace App\Http\AdminApi;

use App\AppModels\DatatableModel;
use App\Core\AppConstant;
use App\Helpers\MediaHelper;
use App\Http\AdminApi\Base\AdminApiController;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class BookingsController extends AdminApiController
{
    private BookingRepositoryInterface $bookingRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository,
                                LogServiceInterface        $logger)
    {
        parent::__construct($logger);

        $this->bookingRepository = $bookingRepository;
    }

    public function list(Request $request): JsonResponse
    {
        $is_admin = boolval($request->get('is_admin'));
        $tenant_id = intval($request->get('tenant_id'));

        $response = new DatatableModel();

        $draw = (int)$request->get('draw');
        $start = (int)$request->get('start');
        $length = (int)$request->get('length');
        $search_param = $request->get('search');
        $search = isset($search_param) && isset($search_param["value"]) ? $search_param["value"] : "";
        $order_by = 'code';

        switch ($this->orderColumn()) {
            case 0:
                $order_by = 'code';
                break;
            case 1:
                $order_by = 'confirmation_code';
                break;
            case 2:
                $order_by = 'book_date';
                break;
            case 3:
                $order_by = 'total_amount';
                break;
            case 4:
                $order_by = 'guests_count';
                break;
        }

        try {
            if ($is_admin)
                $query = $this->bookingRepository->activesPaged($start, $length, $order_by, $this->order(), $search);
            else
                $query = $this->bookingRepository->activesPagedByTenant($tenant_id, $start, $length, $order_by, $this->order(), $search);

            $count = $query["count"];

            if ($search != "")
                $count = $query["data"]->count();

            $response->setDraw($draw);
            $response->setRecordsFiltered($count);
            $response->setRecordsTotal($count);
            $response->setData($query["data"]);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}