<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Core\MediaObjectTypeEnum;
use App\Helpers\AppHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Models\Place;
use App\Services\CityServiceInterface;
use App\Services\CountryServiceInterface;
use App\Services\LogServiceInterface;
use App\Services\PlaceServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Symfony\Component\Console\Input\Input;
use Throwable;

class PlacesController extends AdminController
{
    private PlaceServiceInterface $service;
    private CityServiceInterface $cityService;

    public function __construct(PlaceServiceInterface $service,
                                CityServiceInterface $cityService,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->service = $service;
        $this->cityService = $cityService;
    }

    public function index()
    {
        $data = $this->service->actives();

        $data->each(function ($item, $key) {
            $city = $this->cityService->find($item->city_id);
            if ($city)
                $item->city_name = $city->name;
            else
                $item->city_name = AppConstant::getDash();
        });

        return view('places/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        $cities = $this->cityService->published();

        return view('places/detail', ["data" => $data, "cities" => $cities]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('places/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Place();

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->city_id = $request->get('city_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $db->save();

                if (request()->has('image_path')) {
                    MediaHelper::deletePlacesImage($db->image_path);

                    $image_file = request()->file('image_path');
                    $code = AppHelper::getCode($db->id, MediaObjectTypeEnum::Places);
                    $image_name = $code . '_' . time() . '.' . $image_file->getClientOriginalExtension();

                    Image::make($image_file)->save(MediaHelper::getPlacesPath($image_name));

                    $db->image_path = $image_name;

                    $db->save();

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
        $this->service->deleteLogic($id);

        return redirect("places");
    }
}
