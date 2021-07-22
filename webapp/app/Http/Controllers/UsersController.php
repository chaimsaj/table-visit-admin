<?php

namespace App\Http\Controllers;

use App\AppModels\KeyValueModel;
use App\Core\AppConstant;
use App\Core\AuthModeEnum;
use App\Core\GenderEnum;
use App\Core\MediaObjectTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Models\UserToPlace;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\PlaceRepository;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserToPlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Throwable;

class UsersController extends AdminController
{
    private UserRepositoryInterface $repository;
    private UserToPlaceRepositoryInterface $userToPlaceRepository;
    private PlaceRepositoryInterface $placeRepository;
    private CityRepositoryInterface $cityRepository;

    public function __construct(UserRepositoryInterface $repository,
                                UserToPlaceRepositoryInterface $userToPlaceRepository,
                                PlaceRepositoryInterface $placeRepository,
                                CityRepositoryInterface $cityRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->userToPlaceRepository = $userToPlaceRepository;
        $this->placeRepository = $placeRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $data = $this->repository->all();

        return view('users/index', ["data" => $data, "user_types" => AppHelper::userTypes()]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);

        $all_places = $this->placeRepository->published();

        $by_user = $this->userToPlaceRepository->findByUser($id);

        $places = [];
        $user_places = [];

        foreach ($all_places as $place) {

            $city = $this->cityRepository->find($place->city_id);
            if ($city)
                $place->city_name = $city->name;
            else
                $place->city_name = AppConstant::getDash();

            foreach ($by_user as $selected) {
                if ($selected->place_id == $place->id) {
                    $place->rel_id = $selected->id;
                    array_push($user_places, $place);
                } else
                    array_push($places, $place);
            }

            if ($by_user->count() == 0)
                array_push($places, $place);
        }

        $is_admin = false;

        if (isset($data))
            $is_admin = $data->user_type_id == UserTypeEnum::Admin;

        $tab = Session::get("tab", "data");

        return view('users/detail', ["data" => $data,
            "user_types" => AppHelper::userTypes(),
            "places" => $places,
            "user_places" => $user_places,
            "is_admin" => $is_admin,
            "tab" => $tab
        ]);
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
        $this->repository->delete($id);

        return redirect("users");
    }

    public function save_user_to_place(Request $request, $id): RedirectResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'place_id' => ['required', 'int', 'gt:0'],
            ]);

            if ($validator->fails()) {
                $this->logger->log("user.save_user_to_place error");
            } else {
                $place_id = $request->get('place_id');
                $exists = $this->userToPlaceRepository->existsByUser($place_id, $id);

                if ($exists == null) {
                    $db = new UserToPlace();

                    $db->user_id = $id;
                    $db->place_id = $place_id;
                    $db->published = 1;

                    $this->userToPlaceRepository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "places");

        return redirect()->back();
    }

    public function delete_user_to_place($id): RedirectResponse
    {
        $this->userToPlaceRepository->delete($id);

        Session::flash('tab', "places");

        return redirect()->back();
    }
}
