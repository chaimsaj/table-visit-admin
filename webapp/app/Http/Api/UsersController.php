<?php


namespace App\Http\Api;

use App\AppModels\ApiModel;
use App\Core\AuthModeEnum;
use App\Core\GenderEnum;
use App\Core\UserTypeEnum;
use App\Http\Api\Base\ApiController;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Expr\Array_;
use Throwable;

class UsersController extends ApiController
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository,
                                LogServiceInterface     $logger)
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

    public function update(Request $request): JsonResponse
    {
        $response = new ApiModel();
        $response->setSuccess();

        $data = $request->json()->all();

        try {
            if (Auth::check()) {
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

                    $db->name = $data['email'];
                    $db->last_name = $data['last_name'];

                    $this->userRepository->save($db);
                }
            }
        } catch (Throwable $ex) {
            $response->setError($ex->getMessage());
        }

        return response()->json($response);
    }
}
