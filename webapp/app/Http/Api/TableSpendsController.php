<?php


namespace App\Http\Api;

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
    private TableRepositoryInterface $tableRepository;
    private BookingRepositoryInterface $bookingRepository;
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(TableSpendRepositoryInterface $tableSpendRepository,
                                TableRepositoryInterface      $tableRepository,
                                BookingRepositoryInterface    $bookingRepository,
                                ServiceRepositoryInterface    $serviceRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->tableSpendRepository = $tableSpendRepository;
        $this->tableRepository = $tableRepository;
        $this->bookingRepository = $bookingRepository;
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
                    $query = $this->tableSpendRepository->loadForCustomer(intval($request->get('booking_id')), $user->id);

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

    public function add(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();
                $table = $this->tableRepository->find($request->get('table_id'));
                $booking = $this->bookingRepository->find($request->get('booking_id'));

                if (isset($user) && isset($table) && isset($booking) && $booking->closed_at == null) {

                    $db = new TableSpend();
                    $db->amount = $request->get('amount');
                    $db->tax_amount = $request->get('tax_amount');
                    $db->quantity = $request->get('quantity');
                    $db->total_tax_amount = $request->get('total_tax_amount');
                    $db->total_amount = $request->get('total_amount');
                    $db->user_id = $user->id;
                    $db->booking_id = $booking->id;
                    $db->service_id = $request->get('service_id');
                    $db->table_id = $table->id;
                    $db->place_id = $table->place_id;
                    $db->published = 1;
                    $db->deleted = 0;

                    $this->tableSpendRepository->save($db);

                    $booking->spent_amount += $db->total_amount;
                    $gratuity = floatval(env("TABLE_VISIT_APP_GRATUITY", 20));
                    $booking->spent_gratuity = round((($booking->spent_amount / 100) * $gratuity), 2);
                    $booking->spent_total_amount = $booking->spent_amount + $booking->spent_gratuity;

                    $this->bookingRepository->save($booking);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function remove($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $this->tableSpendRepository->deleteLogic($id);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
