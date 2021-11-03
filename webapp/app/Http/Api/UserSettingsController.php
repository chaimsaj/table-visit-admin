<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\BookingChatStatusEnum;
use App\Http\Api\Base\ApiController;
use App\Models\BookingChat;
use App\Models\UserSetting;
use App\Repositories\UserSettingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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

    public function save(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                if (isset($user)) {
                    $db = $this->userSettingRepository->loadBy($user->id, intval($request->get('setting_type')));

                    if (!isset($db))
                        $db = new UserSetting();

                    $db->setting_type = intval($request->get('setting_type'));
                    $db->active = boolval($request->get('active'));
                    $db->user_id = $user->id;
                    $db->published = 1;
                    $db->deleted = 0;

                    $this->userSettingRepository->save($db);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
