<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\LanguageEnum;
use App\Http\Api\Base\ApiController;
use App\Repositories\TableDetailRepositoryInterface;
use App\Repositories\TableRateRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TablesController extends ApiController
{
    private TableRepositoryInterface $tableRepository;
    private TableDetailRepositoryInterface $tableDetailRepository;
    private TableRateRepositoryInterface $tableRateRepository;

    public function __construct(TableRepositoryInterface       $tableRepository,
                                TableDetailRepositoryInterface $tableDetailRepository,
                                TableRateRepositoryInterface   $tableRateRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->tableRepository = $tableRepository;
        $this->tableDetailRepository = $tableDetailRepository;
        $this->tableRateRepository = $tableRateRepository;
    }

    public function list($place_id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $language = LanguageEnum::English;

        try {
            $query = $this->tableRepository->loadByPlace($place_id);

            foreach ($query as $item) {
                $item->detail = $this->detail($item->id, $language);
            }

            $response->setData($query);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    private function detail(int $table_id, int $language_id): ?Model
    {
        try {
            $data = $this->tableDetailRepository->loadBy($table_id, $language_id);

            if (isset($data))
                return $data;

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return null;
    }

    public function rates(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->tableRateRepository->loadByTable($request->get('table_id'));

            $response->setData($query);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function rate(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->tableRateRepository->firstByTable($request->get('table_id'));

            $response->setData($query);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
