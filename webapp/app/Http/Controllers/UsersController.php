<?php

namespace App\Http\Controllers;

use App\AppModels\KeyValueModel;
use App\Core\AuthModeEnum;
use App\Core\GenderEnum;
use App\Core\MediaObjectTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Services\LogServiceInterface;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Throwable;

class UsersController extends AdminController
{
    private UserServiceInterface $service;

    public function __construct(UserServiceInterface $service,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->all();

        $admin = new KeyValueModel();
        $admin->setKey(UserTypeEnum::Admin);
        $admin->setValue(UserTypeEnum::toString(UserTypeEnum::Admin));

        $guest = new KeyValueModel();
        $guest->setKey(UserTypeEnum::Guest);
        $guest->setValue(UserTypeEnum::toString(UserTypeEnum::Guest));

        $user_types = collect([$admin, $guest]);

        return view('users/index', ["data" => $data, "user_types" => $user_types]);
    }

    public function detail($id)
    {
        $admin = new KeyValueModel();
        $admin->setKey(UserTypeEnum::Admin);
        $admin->setValue(UserTypeEnum::toString(UserTypeEnum::Admin));

        $place_admin = new KeyValueModel();
        $place_admin->setKey(UserTypeEnum::PlaceAdmin);
        $place_admin->setValue(UserTypeEnum::toString(UserTypeEnum::PlaceAdmin));

        $place_employee = new KeyValueModel();
        $place_employee->setKey(UserTypeEnum::PlaceEmployee);
        $place_employee->setValue(UserTypeEnum::toString(UserTypeEnum::PlaceEmployee));

        $guest = new KeyValueModel();
        $guest->setKey(UserTypeEnum::Guest);
        $guest->setValue(UserTypeEnum::toString(UserTypeEnum::Guest));

        $user_types = collect([$admin, $place_admin, $place_employee, $guest]);

        $data = $this->service->find($id);

        return view('users/detail', ["data" => $data, "user_types" => $user_types]);
    }

    public function save(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $validator->after(function ($validator) {
                //$validator->errors()->add('email', 'Something is wrong with this field!');
            });

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('users/detail', ["data" => $request])->withErrors($validator);
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

                $db->save();

                if (request()->has('avatar')) {
                    MediaHelper::deleteUsersImage($db->avatar);

                    $image_file = request()->file('avatar');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Users);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getUsersPath($image_name));

                    $db->avatar = $image_name;

                    $db->save();
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("users");
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return redirect("users");
    }
}
