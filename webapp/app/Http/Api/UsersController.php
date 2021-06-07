<?php


namespace App\Http\Api;

use App\Http\Api\Base\ApiController;
use App\Services\CountryServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\DataTables;

class UsersController extends ApiController
{
    private $service;

    public function __construct(UserServiceInterface $service)
    {
        $this->service = $service;
    }

    public function list(): JsonResponse
    {
        try {
            //return Datatables::of($this->service->all())->make(true);

            return Datatables::of($this->service->all())->setTransformer(function ($data) {
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
        return response()->json($this->countryService->find($id));
    }
}
