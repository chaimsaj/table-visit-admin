<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\LanguageEnum;
use App\Http\Api\Base\ApiController;
use App\Repositories\TableDetailRepositoryInterface;
use App\Repositories\TableRateRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use DateTime;
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

    public function with_date(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $language = LanguageEnum::English;

        try {
            $query = $this->tableRepository->loadByPlace($request->get('place_id'));

            foreach ($query as $item) {
                $item->detail = $this->detail($item->id, $language);
            }

            $response->setData($query);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();
        $language = LanguageEnum::English;

        try {
            $query = $this->tableRepository->find($id);

            if (isset($query))
                $query->detail = $this->detail($query->id, $language);

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
            $date = DateTime::createFromFormat('m-d-Y H:i:s', $request->get('date') . ' 00:00:00');
            $query = $this->tableRateRepository->rate($request->get('table_id'), $date);

            if (isset($query)) {
                $gratuity = floatval(env("TABLE_VISIT_APP_GRATUITY", 20));

                $query->gratuity = round((($query->total_rate / 100) * $gratuity), 2);
                $query->total_rate = round($query->total_rate + $query->gratuity, 2);

                $query->gratuity = strval($query->gratuity);
                $query->total_rate = strval($query->total_rate);

                $response->setData($query);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
