<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Core\MediaObjectTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Models\Place;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\UserToPlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;
use Throwable;

class PlacesController extends AdminController
{
    private PlaceRepositoryInterface $repository;
    private CityRepositoryInterface $cityRepository;
    private UserToPlaceRepositoryInterface $userToPlaceRepository;

    public function __construct(PlaceRepositoryInterface $repository,
                                CityRepositoryInterface $cityRepository,
                                UserToPlaceRepositoryInterface $userToPlaceRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
        $this->userToPlaceRepository = $userToPlaceRepository;
    }

    public function index()
    {
        $data = [];
        $places = $this->repository->actives();

        foreach ($places as $place) {
            $to_add = true;

            if (Auth::user()->user_type_id != UserTypeEnum::Admin) {
                $to_add = null;
                $by_user = $this->userToPlaceRepository->findByUser(Auth::user()->id);

                foreach ($by_user as $selected) {
                    if ($selected->place_id == $place->id) {
                        $to_add = true;
                        break;
                    } else
                        $to_add = null;
                }
            }

            if (isset($to_add)) {
                $city = $this->cityRepository->find($place->city_id);
                if ($city)
                    $place->city_name = $city->name;
                else
                    $place->city_name = AppConstant::getDash();

                array_push($data, $place);
            }
        }

        return view('places/index', ["data" => $data]);
    }

    public function detail($id)
    {
        if (Auth::user()->user_type_id != UserTypeEnum::Admin) {
            $exists = $this->userToPlaceRepository->existsByUser($id, Auth::user()->id);

            if ($exists == null)
                return redirect("/");
        }

        $data = $this->repository->find($id);
        $cities = $this->cityRepository->published();

        return view('places/detail', ["data" => $data, "cities" => $cities]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                return view('places/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Place();

                $db->name = $request->get('name');
                $db->address = $request->get('address');
                $db->display_order = intval($request->get('display_order'));
                $db->city_id = $request->get('city_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";
                $db->accept_reservations = $request->get('accept_reservations') == "on";
                $db->open = $request->get('open') == "on";

                $this->repository->save($db);

                if (request()->has('image_path')) {
                    MediaHelper::deletePlacesImage($db->image_path);

                    $image_file = request()->file('image_path');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Places);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getPlacesPath($image_name));

                    $db->image_path = $image_name;

                    $this->repository->save($db);

                    // Image::make(Input::file('image_path'))->resize(300, 200)->save('foo.jpg');
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("places");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);

        return redirect("places");
    }
}
