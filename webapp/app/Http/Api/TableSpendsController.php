<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Models\TableSpend;
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

    public function __construct(TableSpendRepositoryInterface $tableSpendRepository,
                                TableRepositoryInterface      $tableRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->tableSpendRepository = $tableSpendRepository;
        $this->tableRepository = $tableRepository;
    }

    public function add(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $db = new TableSpend();
                    $db->amount = $request->get('amount');
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
