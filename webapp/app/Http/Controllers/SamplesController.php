<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SamplesController extends AdminController
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->all();

        return view('samples/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->userService->find($id);

        return view('samples/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        $user = null;

        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);

            $validator->after(function ($validator) {
                //$validator->errors()->add('email', 'Something is wrong with this field!');
            });

            $user = $this->userService->find($id);

            if ($validator->fails() && $user == null) {
                /*return redirect('post/create')
                    ->withErrors($validator)
                    ->withInput();*/
                //return redirect()->back()->withErrors($validator)->withInput($request->all());
                return view('samples/detail', ["data" => $request])->withErrors($validator);
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
                $user->email = $request->get('email');

                if (!empty($request->get('password')))
                    $user->password = $request->get('password');

                $user->dob = date('Y-m-d', strtotime($request->get('dob')));

                if (!empty($avatarName))
                    $user->avatar = '/images/' . $avatarName;
                else {
                    if ($user->id == 0)
                        $user->avatar = "";
                }

                $user->save();
            }

        } catch (Throwable $ex) {
            return $ex;
        }

        return redirect("samples");
    }

    public function delete($id)
    {
        $this->userService->delete($id);

        return redirect("samples");
    }
}
