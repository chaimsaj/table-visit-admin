<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\AuthModeEnum;
use App\Core\GenderEnum;
use App\Core\MediaObjectTypeEnum;
use App\Core\MediaSizeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Api\Base\ApiController;
use App\Models\User;
use App\Models\UserProfile;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use PhpParser\Node\Expr\Array_;
use Throwable;

class UsersController extends ApiController
{
    private UserRepositoryInterface $userRepository;
    private UserProfileRepositoryInterface $userProfileRepository;

    public function __construct(UserRepositoryInterface        $userRepository,
                                UserProfileRepositoryInterface $userProfileRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->userRepository = $userRepository;
        $this->userProfileRepository = $userProfileRepository;
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
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function find($id): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $query = $this->userRepository->find($id);
                $response->setData($query);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function load_profile(): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();
                $profile = $this->userProfileRepository->loadByUser($user->id);
                $response->setData($profile);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function save_phone_number(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $data = $request->json()->all();

                $rules = [
                    'phone_number' => ['required', 'string', 'max:50'],
                ];

                $validator = Validator::make($data, $rules);

                if ($validator->fails()) {
                    $response->setError($validator->getMessageBag());
                    return response()->json($response);
                }

                $user = Auth::user();

                $db = $this->userProfileRepository->loadByUser($user->id);

                if (!isset($db))
                    $db = new UserProfile();

                $db->phone_number = $data['phone_number'];
                $db->user_id = $user->id;

                $this->userProfileRepository->save($db);
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function update(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $data = $request->json()->all();

                $user = Auth::user();

                $db = $this->userRepository->find($user->id);

                if (isset($db)) {
                    $rules = [
                        'name' => ['required', 'string', 'max:255'],
                        'last_name' => ['required', 'string', 'max:255'],
                    ];

                    $validator = Validator::make($data, $rules);

                    if ($validator->fails()) {
                        $response->setError($validator->getMessageBag());
                        return response()->json($response);
                    }

                    if ($db->email != $data['email']) {
                        $rules = [
                            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                        ];

                        $validator = Validator::make($data, $rules);

                        if ($validator->fails()) {
                            $response->setError($validator->getMessageBag());
                            return response()->json($response);
                        }

                        $db->email = $data['email'];
                    }

                    $db->name = $data['name'];
                    $db->last_name = $data['last_name'];
                    $db->gender = intval($data['gender']);

                    // $db->dob = date('Y-m-d', strtotime($request->get('dob')));
                    // $db->last_name = $data['last_name'];

                    $this->userRepository->save($db);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function upload_avatar(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                $db = $this->userRepository->find($user->id);

                if (isset($db) && $request->has('avatar')) {
                    $image_file = $request->file('avatar');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Users);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getUsersPath($image_name));

                    $db->avatar = $image_name;

                    $db->save();
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function upload_government_id(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $user = Auth::user();

                $db = $this->userProfileRepository->loadByUser($user->id);

                if (!isset($db))
                    $db = new UserProfile();

                if ($request->has('government_id')) {
                    $image_file = $request->file('government_id');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Users);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getGovernmentIdsPath($image_name));

                    $db->government_id_path = $image_name;
                    $db->user_id = $user->id;

                    $db->save();
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }

    public function save_timezone(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        try {
            if (Auth::check()) {
                $data = $request->json()->all();

                $rules = [
                    'timezone_offset' => ['required', 'int'],
                ];

                $validator = Validator::make($data, $rules);

                if ($validator->fails()) {
                    $response->setError($validator->getMessageBag());
                    return response()->json($response);
                }

                $user = Auth::user();

                $db = $this->userRepository->find($user->id);

                if (isset($db)) {
                    $db->timezone_offset = intval($data['timezone_offset']);

                    $this->userRepository->save($db);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
