<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Throwable;

class UsersController extends ApiController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->userRepository = $userRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            $query = $this->userRepository->published();
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

        try {
            $query = $this->userRepository->find($id);
            $response->setData($query);
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return response()->json($response);
    }
}
