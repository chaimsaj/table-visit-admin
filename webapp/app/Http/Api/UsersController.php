<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\DataTables;

class UsersController extends ApiController
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function list(): JsonResponse
    {
        try {
            //return Datatables::of($this->repository->all())->make(true);

            $query = $this->repository->all();

            return Datatables::of($query)->setTransformer(function ($data) {
                return [
                    'id' => (int)$data->id,
                    'name' => $data->name,
                    'email' => $data->email,
                    'created_at' => (string)$data->created_at,
                    'updated_at' => (string)$data->updated_at,
                ];
            })->toJson();

        } catch (Throwable $ex) {
            return response()->json($ex->getMessage());
        }

        //return response()->json($this->countryService->all());
    }

    public function find($id): JsonResponse
    {
        return response()->json($this->repository->find($id));
    }
}
