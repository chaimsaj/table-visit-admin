<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Core\LanguageEnum;
use App\Core\MediaObjectTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Models\Place;
use App\Models\PlaceDetail;
use App\Models\PlaceToFeature;
use App\Models\PlaceToMusic;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\LanguageRepositoryInterface;
use App\Repositories\PlaceDetailRepositoryInterface;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceToFeatureRepositoryInterface;
use App\Repositories\PlaceToMusicRepositoryInterface;
use App\Repositories\UserToPlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;
use Throwable;

class PlacesController extends AdminController
{
    private PlaceRepositoryInterface $repository;
    private CityRepositoryInterface $cityRepository;
    private UserToPlaceRepositoryInterface $userToPlaceRepository;
    private PlaceFeatureRepositoryInterface $placeFeatureRepository;
    private PlaceMusicRepositoryInterface $placeMusicRepository;
    private PlaceDetailRepositoryInterface $placeDetailRepository;
    private PlaceToFeatureRepositoryInterface $placeToFeatureRepository;
    private PlaceToMusicRepositoryInterface $placeToMusicRepository;

    public function __construct(PlaceRepositoryInterface $repository,
                                CityRepositoryInterface $cityRepository,
                                UserToPlaceRepositoryInterface $userToPlaceRepository,
                                PlaceFeatureRepositoryInterface $placeFeatureRepository,
                                PlaceMusicRepositoryInterface $placeMusicRepository,
                                PlaceDetailRepositoryInterface $placeDetailRepository,
                                PlaceToFeatureRepositoryInterface $placeToFeatureRepository,
                                PlaceToMusicRepositoryInterface $placeToMusicRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->cityRepository = $cityRepository;
        $this->userToPlaceRepository = $userToPlaceRepository;
        $this->placeFeatureRepository = $placeFeatureRepository;
        $this->placeMusicRepository = $placeMusicRepository;
        $this->placeDetailRepository = $placeDetailRepository;
        $this->placeToFeatureRepository = $placeToFeatureRepository;
        $this->placeToMusicRepository = $placeToMusicRepository;
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
        //$languages = $this->languageRepository->published();
        $features = $this->placeFeatureRepository->published();
        $music = $this->placeMusicRepository->published();

        $place_detail = $this->placeDetailRepository->loadBy($id, LanguageEnum::English);

        $tab = Session::get("tab", "data");

        return view('places/detail', ["data" => $data,
            "cities" => $cities,
            //"languages" => $languages,
            "features" => $features,
            "music" => $music,
            "place_detail" => $place_detail,
            "tab" => $tab
        ]);
    }

    public function save(Request $request, $id)
    {
        try {
            /*$validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'address' => ['required', 'string', 'max:255'],
            ]);*/

            $db = $this->repository->find($id);

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

            /*if ($validator->fails() && $db == null) {
                return view('places/detail', ["data" => $request])->withErrors($validator);
            } else {

            }*/

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

    //Details
    public function save_details(Request $request, $id): RedirectResponse
    {
        try {
            $db = $this->placeDetailRepository->loadBy($id, LanguageEnum::English);

            if ($db == null)
                $db = new PlaceDetail();

            $db->detail = $request->get('place_detail');
            $db->place_id = $id;
            $db->language_id = LanguageEnum::English;
            $db->published = 1;

            $this->placeDetailRepository->save($db);

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "details");

        return redirect()->back();
    }

    //Floor Plan
    public function save_floor_plan(Request $request, $id): RedirectResponse
    {
        try {
            $db = $this->repository->find($id);

            if ($db != null) {
                if ($request->has('floor_plan_path')) {
                    MediaHelper::deletePlacesImage($db->floor_plan_path);

                    $image_file = $request->file('floor_plan_path');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Places);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getPlacesPath($image_name));

                    $db->floor_plan_path = $image_name;

                    $this->repository->save($db);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "floor-plan");

        return redirect()->back();
    }

    //Food Menu
    public function save_food_menu(Request $request, $id): RedirectResponse
    {
        try {
            $db = $this->repository->find($id);

            if ($db != null) {
                if ($request->has('food_menu_path')) {
                    MediaHelper::deletePlacesImage($db->food_menu_path);

                    $image_file = $request->file('food_menu_path');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Places);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getPlacesPath($image_name));

                    $db->food_menu_path = $image_name;

                    $this->repository->save($db);
                }
            }
        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "food-menu");

        return redirect()->back();
    }

    //Features
    public function save_feature_to_place(Request $request, $id): RedirectResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'feature_id' => ['required', 'int', 'gt:0'],
            ]);

            if ($validator->fails()) {
                $this->logger->log("place.save_feature_to_place error");
            } else {
                $feature_id = $request->get('feature_id');
                $exists = $this->placeToFeatureRepository->existsByPlace($feature_id, $id);

                if ($exists == null) {
                    $db = new PlaceToFeature();

                    $db->place_id = $id;
                    $db->feature_id = $feature_id;
                    $db->published = 1;

                    $this->placeToFeatureRepository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "features");

        return redirect()->back();
    }

    public function delete_feature_to_place($id): RedirectResponse
    {
        $this->placeToFeatureRepository->delete($id);

        Session::flash('tab', "features");

        return redirect()->back();
    }

    //Music
    public function save_music_to_place(Request $request, $id): RedirectResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'music_id' => ['required', 'int', 'gt:0'],
            ]);

            if ($validator->fails()) {
                $this->logger->log("place.save_music_to_place error");
            } else {
                $music_id = $request->get('music_id');
                $exists = $this->placeToMusicRepository->existsByPlace($music_id, $id);

                if ($exists == null) {
                    $db = new PlaceToMusic();

                    $db->place_id = $id;
                    $db->music_id = $music_id;
                    $db->published = 1;

                    $this->placeToMusicRepository->save($db);
                }
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "music");

        return redirect()->back();
    }

    public function delete_music_to_place($id): RedirectResponse
    {
        $this->placeToMusicRepository->delete($id);

        Session::flash('tab', "music");

        return redirect()->back();
    }
}
