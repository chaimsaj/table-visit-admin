<?php

namespace App\Http\Controllers\Auth;

use App\Core\AuthModeEnum;
use App\Core\GenderEnum;
use App\Core\MediaFileTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\BasicController;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class RegisterController extends BasicController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            /*'dob' => ['required', 'date', 'before:today'],
            'avatar' => ['required', 'image' ,'mimes:jpg,jpeg,png','max:1024'],*/
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        $db = new User();

        $db->name = $data['name'];
        $db->last_name = $data['last_name'];
        $db->email = $data['email'];
        $db->password = Hash::make($data['password']);
        $db->auth_mode = AuthModeEnum::Basic;
        $db->user_type_id = UserTypeEnum::Admin;
        $db->gender = GenderEnum::Undefined;

        $db->save();

        if (request()->has('avatar')) {
            $image_file = request()->file('avatar');
            $code = AppHelper::getCode($db->id, MediaFileTypeEnum::Users);
            $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

            Image::make($image_file)->save(MediaHelper::getUsersPath($image_name));

            $db->avatar = $image_name;

            $db->save();
        }

        return $db;
    }
}
