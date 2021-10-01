<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Models\TableSpend;
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
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(TableSpendRepositoryInterface $tableSpendRepository,
                                TableRepositoryInterface      $tableRepository,
                                ServiceRepositoryInterface    $serviceRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->tableSpendRepository = $tableSpendRepository;
        $this->tableRepository = $tableRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function add(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();
                $table = $this->tableRepository->find($request->get('table_id'));

                if (isset($user) && isset($table)) {
                    $db = new TableSpend();
                    $db->amount = $request->get('amount');
                    $db->tax_amount = $request->get('tax_amount');
                    $db->quantity = $request->get('quantity');
                    $db->total_tax_amount = $request->get('total_tax_amount');
                    $db->total_amount = $request->get('total_amount');
                    $db->service_id = $request->get('service_id');
                    $db->table_id = $table->id;
                    $db->place_id = $table->place_id;
                    $db->user_id = $user->id;
                    $db->published = 1;
                    $db->deleted = 0;

                    $this->tableSpendRepository->save($db);
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
