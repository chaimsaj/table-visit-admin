<?php

namespace App\Http\Controllers;

use App\AppModels\KeyValueModel;
use App\Core\AuthModeEnum;
use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsersController extends AdminController
{
    private UserServiceInterface $service;

    public function __construct(UserServiceInterface $service)
    {
        parent::__construct();
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

        $guest = new KeyValueModel();
        $guest->setKey(UserTypeEnum::Guest);
        $guest->setValue(UserTypeEnum::toString(UserTypeEnum::Guest));

        $user_types = collect([$admin, $guest]);

        $data = $this->service->find($id);

        return view('users/detail', ["data" => $data, "user_types" => $user_types]);
    }

    public function save(Request $request, $id)
    {
        $user = null;

        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);

            $validator->after(function ($validator) {
                //$validator->errors()->add('email', 'Something is wrong with this field!');
            });

            $user = $this->service->find($id);

            if ($validator->fails() && $user == null) {
                /*return redirect('post/create')
                    ->withErrors($validator)
                    ->withInput();*/
                //return redirect()->back()->withErrors($validator)->withInput($request->all());
                return view('users/detail', ["data" => $request])->withErrors($validator);
            } else {
                $avatarName = "";

                if (request()->has('avatar')) {
                    $avatar = request()->file('avatar');
                    $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                    $avatarPath = public_path('/images/');
                    $avatar->move($avatarPath, $avatarName);
                }

                /* if ($request->file('avatar')) {
                     $avatar = $request->file('avatar');
                     $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                     $avatarPath = public_path('/images/');
                     $avatar->move($avatarPath, $avatarName);
                     if (file_exists(public_path('/images/' . $avatarName))) {
                         unlink(public_path('/images/' . $avatarName));
                     }
                 }*/

                if ($user == null)
                    $user = new User();

                $user->name = $request->get('name');
                $user->last_name = '';
                $user->email = $request->get('email');

                if (!empty($request->get('password')))
                    $user->password = Hash::make($request->get('password'));

                $user->auth_mode = AuthModeEnum::Basic;
                $user->user_type_id = UserTypeEnum::Admin;

                //$user->dob = date('Y-m-d', strtotime($request->get('dob')));

                if (!empty($avatarName))
                    $user->avatar = '/images/' . $avatarName;
                else {
                    if ($user->id == 0)
                        $user->avatar = "";
                }

                $user->save();
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
