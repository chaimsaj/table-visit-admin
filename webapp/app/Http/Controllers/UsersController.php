<?php

namespace App\Http\Controllers;

use App\Core\AuthModeEnum;
use App\Core\GenderEnum;
use App\Core\MediaObjectTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\TenantRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Services\LogServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Collection;
use Throwable;

class UsersController extends AdminController
{
    private UserRepositoryInterface $repository;
    private TenantRepositoryInterface $tenantRepository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(UserRepositoryInterface   $repository,
                                TenantRepositoryInterface $tenantRepository,
                                PlaceRepositoryInterface  $placeRepository,
                                LogServiceInterface       $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->tenantRepository = $tenantRepository;
        $this->placeRepository = $placeRepository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = new Collection();

        if ($is_admin) {
            $data = $this->repository->actives();
            foreach ($data as $item) {
                $item->user_type_name = AppHelper::userType($item->user_type_id);
            }
        } else {
            $users = $this->repository->activesByTenant(Auth::user()->tenant_id);
            foreach ($users as $user) {
                $user->user_type_name = AppHelper::userType($user->user_type_id);
                $data->push($user);
            }
        }

        return view('users/index', ["data" => $data,
            "user_types" => AppHelper::userTypesAll(),
            "is_admin" => $is_admin
        ]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->repository->find($id);

        $tenants = $this->tenantRepository->actives();

        if ($is_admin)
            $places = $this->placeRepository->actives();
        else
            $places = $this->placeRepository->activesByTenant(Auth::user()->tenant_id);

        $tab = Session::get("tab", "data");

        return view('users/detail', ["data" => $data,
            "user_types" => AppHelper::userTypes($is_admin),
            "tenants" => $tenants,
            "places" => $places,
            "is_admin" => $is_admin,
            "tab" => $tab
        ]);
    }

    public function save(Request $request, $id)
    {
        try {

            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $validator->after(function ($validator) {
                //$validator->errors()->add('email', 'Something is wrong with this field!');
            });

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                $tab = Session::get("tab", "data");
                return view('users/detail', ["data" => $request,
                    "tab" => $tab,
                    "user_types" => AppHelper::userTypes()
                ])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new User();

                $db->name = $request->get('name');
                $db->last_name = $request->get('last_name');
                $db->email = $request->get('email');

                if (!empty($request->get('password')))
                    $db->password = Hash::make($request->get('password'));

                $db->auth_mode = AuthModeEnum::Basic;
                $db->user_type_id = intval($request->get('user_type_id'));
                $db->gender = GenderEnum::Undefined;
                $db->published = $request->get('published') == "on";

                if ($db->email_verified_at == null)
                    $db->email_verified_at = now();

                //$db->dob = date('Y-m-d', strtotime($request->get('dob')));

                if (!$is_admin)
                    $db->place_id = intval($request->get('place_id'));
                else
                    $db->tenant_id = intval($request->get('tenant_id'));

                $this->repository->save($db);

                if (request()->has('avatar')) {
                    MediaHelper::deleteUsersImage($db->avatar);

                    $image_file = request()->file('avatar');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Users);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getUsersPath($image_name));

                    $db->avatar = $image_name;

                    $this->repository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("users");
    }

    public function delete($id)
    {
        if ($id != 1)
            $this->repository->delete($id);

        return redirect("users");
    }
}
