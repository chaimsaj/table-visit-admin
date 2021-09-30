<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Http\Api\Base\ApiController;
use App\Repositories\UserSettingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Throwable;

class UserSettingsController extends ApiController
{
    private UserSettingRepositoryInterface $userSettingRepository;

    public function __construct(UserSettingRepositoryInterface $userSettingRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->userSettingRepository = $userSettingRepository;
    }

    public function list(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $query = $this->userSettingRepository->published();
                    $response->setData($query);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
