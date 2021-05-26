<?php

namespace App\Http\Controllers;

use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsersController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $data = $this->userService->all();

        return view('users/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->userService->find($id);

        return view('users/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        //$data = $this->userService->find($id);

        $user = null;

        try {
            $avatarName = "";

            if ($request->file('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/images/');
                $avatar->move($avatarPath, $avatarName);
                if (file_exists(public_path('/images/' . $avatarName))) {
                    unlink(public_path('/images/' . $avatarName));
                }

            }

            $user = $this->userService->find($id);
            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = $request->get('password');
            $user->dob = date('Y-m-d', strtotime($request->get('dob')));
            $user->avatar = '/images/' . $avatarName;
            $user->save();

        } catch (Throwable $e) {
            return $e;
        }

        return redirect("users");
        //return view('users/detail', ["data" => $user]);
    }

    public function store(Request $request)
    {
        try {
            $avatarName = "";

            if ($request->file('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/images/');
                $avatar->move($avatarPath, $avatarName);
                if (file_exists(public_path('/images/' . $avatarName))) {
                    unlink(public_path('/images/' . $avatarName));
                }
            }

            $user = new User();

            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = $request->get('password');
            $user->dob = date('Y-m-d', strtotime($request->get('dob')));
            $user->avatar = '/images/' . $avatarName;
            $user->save();

        } catch (Throwable $e) {
            return $e;
        }
        //return $request->input();
        return redirect("/users");

    }
}
