<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Models\City;
use App\Services\CityServiceInterface;
use App\Services\CountryServiceInterface;
use App\Services\StateServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CitiesController extends AdminController
{
    private CityServiceInterface $service;
    private CountryServiceInterface $countryService;
    private StateServiceInterface $stateService;

    public function __construct(CityServiceInterface $service
        , CountryServiceInterface $countryService
        , StateServiceInterface $stateService)
    {
        parent::__construct();

        $this->service = $service;
        $this->countryService = $countryService;
        $this->stateService = $stateService;
    }

    public function index()
    {
        $data = $this->service->actives();

        $data->each(function ($item, $key) {
            $country = $this->countryService->find($item->country_id);

            if ($country)
                $item->country_name = $country->name;
            else
                $item->country_name = AppConstant::getDash();

            $state = $this->stateService->find($item->state_id);

            if ($state)
                $item->state_name = $state->name;
            else
                $item->state_name = AppConstant::getDash();
        });

        return view('cities/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        $countries = $this->countryService->published();
        $states = new Collection();

        if ($data != null)
            $states = $this->stateService->publishedByCountry($data->country_id);

        return view('cities/detail', ["data" => $data, "countries" => $countries, "states" => $states]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'display_order' => ['required', 'int'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('cities/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new City();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('display_order'));
                $db->country_id = $request->get('country_id');
                $db->state_id = $request->get('state_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $db->save();
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("cities");
    }

    public function delete($id)
    {
        $this->service->deleteLogic($id);
        return redirect("cities");
    }
}
