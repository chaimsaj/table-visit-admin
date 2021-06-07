<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BackupController extends BasicController
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
        //  return view('users/index')->with('data',$data);


    }

    public function create()
    {

        return view('users/create');
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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = $this->userService->find($id);
        return view('users/edit', ["user" => $user]);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->find($id);

            if ($request->file('avatar')) {
                $avatar = $request->file('avatar');
                $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
                $avatarPath = public_path('/images/');
                $avatar->move($avatarPath, $avatarName);
                if (file_exists(public_path($user->avatar))) {
                    unlink(public_path($user->avatar));
                }
                $user->avatar = '/images/' . $avatarName;
            }


            $user->name = $request->get('name');
            $user->email = $request->get('email');
            $user->password = $request->get('password');
            $user->dob = date('Y-m-d', strtotime($request->get('dob')));

            $user->update();

        } catch (Throwable $e) {
            return $e;
        }
        //return $request->input();
        return redirect("/users");
    }

    public function destroy($id)
    {
        //
    }
}
