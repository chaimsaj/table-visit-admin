<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Core\LanguageEnum;
use App\Core\MediaObjectTypeEnum;
use App\Core\PolicyTypeEnum;
use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\GoogleStorageHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Models\Place;
use App\Models\PlaceDetail;
use App\Models\PlaceToFeature;
use App\Models\PlaceToMusic;
use App\Models\PlaceToPlaceType;
use App\Models\Policy;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\PlaceDetailRepositoryInterface;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceToFeatureRepositoryInterface;
use App\Repositories\PlaceToMusicRepositoryInterface;
use App\Repositories\PlaceToPlaceTypeRepositoryInterface;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Repositories\PolicyRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Throwable;

class PlacesController extends AdminController
{
    private PlaceRepositoryInterface $repository;
    private StateRepositoryInterface $stateRepository;
    private CityRepositoryInterface $cityRepository;
    private TenantRepositoryInterface $tenantRepository;
    private PlaceFeatureRepositoryInterface $placeFeatureRepository;
    private PlaceMusicRepositoryInterface $placeMusicRepository;
    private PlaceDetailRepositoryInterface $placeDetailRepository;
    private PlaceToFeatureRepositoryInterface $placeToFeatureRepository;
    private PlaceToMusicRepositoryInterface $placeToMusicRepository;
    private PolicyRepositoryInterface $policyRepository;
    private PlaceTypeRepositoryInterface $placeTypeRepository;
    private PlaceToPlaceTypeRepositoryInterface $placeToPlaceTypeRepository;

    public function __construct(PlaceRepositoryInterface            $repository,
                                StateRepositoryInterface            $stateRepository,
                                CityRepositoryInterface             $cityRepository,
                                TenantRepositoryInterface           $tenantRepository,
                                PlaceFeatureRepositoryInterface     $placeFeatureRepository,
                                PlaceMusicRepositoryInterface       $placeMusicRepository,
                                PlaceDetailRepositoryInterface      $placeDetailRepository,
                                PlaceToFeatureRepositoryInterface   $placeToFeatureRepository,
                                PlaceToMusicRepositoryInterface     $placeToMusicRepository,
                                PolicyRepositoryInterface           $policyRepository,
                                PlaceTypeRepositoryInterface        $placeTypeRepository,
                                PlaceToPlaceTypeRepositoryInterface $placeToPlaceTypeRepository,
                                LogServiceInterface                 $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->stateRepository = $stateRepository;
        $this->cityRepository = $cityRepository;
        $this->tenantRepository = $tenantRepository;
        $this->placeFeatureRepository = $placeFeatureRepository;
        $this->placeMusicRepository = $placeMusicRepository;
        $this->placeDetailRepository = $placeDetailRepository;
        $this->placeToFeatureRepository = $placeToFeatureRepository;
        $this->placeToMusicRepository = $placeToMusicRepository;
        $this->policyRepository = $policyRepository;
        $this->placeTypeRepository = $placeTypeRepository;
        $this->placeToPlaceTypeRepository = $placeToPlaceTypeRepository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $places = $this->repository->actives();
        else
            $places = $this->repository->activesByTenant(Auth::user()->tenant_id);

        foreach ($places as $place) {
            $city = $this->cityRepository->find($place->city_id);

            if (isset($city))
                $place->city_name = $city->name;
            else
                $place->city_name = AppConstant::getDash();
        }

        return view('places/index', ["data" => $places]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->repository->find($id);

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        $place_detail = null;
        $states = $this->stateRepository->published();
        $cities = new Collection();
        $tenants = new Collection();

        if ($is_admin)
            $tenants = $this->tenantRepository->actives();

        if (isset($data)) {
            $place_detail = $this->placeDetailRepository->loadBy($id, LanguageEnum::English);
            $cities = $this->cityRepository->publishedByState($data->state_id);

            $place_to_place_type = $this->placeToPlaceTypeRepository->findFirstByPlace($data->id);

            if (isset($place_to_place_type))
                $data->place_type_id = $place_to_place_type->place_type_id;
        }

        $tenant_id = null;

        if (!$is_admin)
            $tenant_id = Auth::user()->tenant_id;

        $place_features = $this->placeFeatureRepository->shown($id);
        $features = $this->placeFeatureRepository->publishedExclude($place_features->pluck('id'), $tenant_id);

        $place_music = $this->placeMusicRepository->shown($id);
        $music = $this->placeMusicRepository->publishedExclude($place_music->pluck('id'), $tenant_id);

        $place_reservation_policy = $this->policyRepository->loadBy($id, PolicyTypeEnum::Reservation, LanguageEnum::English);
        $place_cancellation_policy = $this->policyRepository->loadBy($id, PolicyTypeEnum::Cancellation, LanguageEnum::English);

        $place_types = $this->placeTypeRepository->published();

        $tab = Session::get("tab", "data");

        return view('places/detail', ["data" => $data,
            "states" => $states,
            "cities" => $cities,
            "tenants" => $tenants,
            "place_detail" => $place_detail,
            "features" => $features,
            "place_features" => $place_features,
            "music" => $music,
            "place_music" => $place_music,
            "place_reservation_policy" => $place_reservation_policy,
            "place_cancellation_policy" => $place_cancellation_policy,
            "is_admin" => $is_admin,
            "place_types" => $place_types,
            "tab" => $tab
        ]);
    }

    public function save(Request $request, $id)
    {
        try {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $db = $this->repository->find($id);

            if ($db == null) {
                $db = new Place();

                if (!$is_admin)
                    $db->tenant_id = Auth::user()->tenant_id;
            }

            $db->name = $request->get('name');
            $db->address = $request->get('address');
            $db->open_at = intval($request->get('open_at'));
            $db->close_at = intval($request->get('close_at'));
            $db->display_order = intval($request->get('display_order'));
            $db->city_id = $request->get('city_id');
            $db->state_id = $request->get('state_id');
            $db->published = $request->get('published') == "on";
            $db->show = $request->get('show') == "on";
            $db->accept_reservations = $request->get('accept_reservations') == "on";
            $db->open = $request->get('open') == "on";

            if ($is_admin)
                $db->tenant_id = intval($request->get('tenant_id'));

            $place_type_id = intval($request->get('place_type_id'));

            $this->repository->save($db);

            if ($place_type_id > 0) {
                $place_to_place_type = $this->placeToPlaceTypeRepository->existsByPlace($place_type_id, $db->id);

                if (!isset($place_to_place_type)) {
                    $place_to_place_type = new PlaceToPlaceType();
                    $place_to_place_type->place_id = $db->id;
                    $place_to_place_type->place_type_id = $place_type_id;
                    $place_to_place_type->published = 1;

                    $this->placeToPlaceTypeRepository->save($place_to_place_type);
                }
            } else {
                $place_to_place_type = $this->placeToPlaceTypeRepository->findFirstByPlace($db->id);

                if (isset($place_to_place_type))
                    $this->placeToPlaceTypeRepository->delete($place_to_place_type->id);
            }

            if ($request->has('image_path')) {
                MediaHelper::deletePlacesImage($db->image_path);

                $image_file = $request->file('image_path');
                $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Places);
                $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();


                Image::make($image_file)->save(public_path(MediaHelper::getPlacesPath($image_name)));
                GoogleStorageHelper::upload(MediaHelper::getPlacesPath($image_name));

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
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->repository->find($id);

        if (isset($data) && ($is_admin || $data->tenant_id == Auth::user()->tenant_id))
            $this->repository->deleteLogic($id);

        return redirect("places");
    }

    // Details
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

    // Floor Plan
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

    // Food Menu
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

    // Features
    public function save_feature_to_place(Request $request, $id): RedirectResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'place_feature_id' => ['required', 'int', 'gt:0'],
            ]);

            if ($validator->fails()) {
                $this->logger->log("place.save_feature_to_place error");
            } else {
                $place_feature_id = $request->get('place_feature_id');
                $exists = $this->placeToFeatureRepository->existsByPlace($place_feature_id, $id);

                if ($exists == null) {
                    $db = new PlaceToFeature();

                    $db->place_id = $id;
                    $db->place_feature_id = $place_feature_id;
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

    // Music
    public function save_music_to_place(Request $request, $id): RedirectResponse
    {
        try {

            $validator = Validator::make($request->all(), [
                'place_music_id' => ['required', 'int', 'gt:0'],
            ]);

            if ($validator->fails()) {
                $this->logger->log("place.save_music_to_place error");
            } else {
                $place_music_id = $request->get('place_music_id');
                $exists = $this->placeToMusicRepository->existsByPlace($place_music_id, $id);

                if ($exists == null) {
                    $db = new PlaceToMusic();

                    $db->place_id = $id;
                    $db->place_music_id = $place_music_id;
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

    // Policies
    public function save_policies(Request $request, $id): RedirectResponse
    {
        try {
            $place = $this->repository->find($id);

            if (isset($place)) {
                $this->save_policy($request->get('place_reservation_policy'), $place, PolicyTypeEnum::Reservation);
                $this->save_policy($request->get('place_cancellation_policy'), $place, PolicyTypeEnum::Cancellation);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        Session::flash('tab', "policies");

        return redirect()->back();
    }

    private function save_policy($detail, $place, $policy_type)
    {
        $language = LanguageEnum::English;
        $db = $this->policyRepository->loadBy($place->id, $policy_type, $language);

        if ($db == null)
            $db = new Policy();

        $db->title = '';
        $db->introduction = '';
        $db->detail = $detail;
        $db->show = 1;
        $db->policy_type = $policy_type;
        $db->place_id = $place->id;
        $db->tenant_id = $place->tenant_id;
        $db->language_id = $language;
        $db->published = 1;

        $this->policyRepository->save($db);
    }
}
