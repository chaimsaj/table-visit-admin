<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Http\Controllers\Base\AdminController;
use App\Models\State;
use App\Services\CountryServiceInterface;
use App\Services\StateServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatesController extends AdminController
{
    private StateServiceInterface $service;
    private CountryServiceInterface $countryService;

    public function __construct(StateServiceInterface $service, CountryServiceInterface $countryService)
    {
        parent::__construct();

        $this->service = $service;
        $this->countryService = $countryService;
    }

    public function index()
    {
        $data = $this->service->all();

        $data->each(function ($item, $key) {
            $country = $this->countryService->find($item->country_id);
            if ($country)
                $item->country_name = $country->name;
            else
                $item->country_name = AppConstant::getDash();
        });

        return view('states/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        $countries = $this->countryService->pu();
        return view('states/detail', ["data" => $data, "countries" => $countries]);
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
                return view('states/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new State();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('display_order'));
                $db->country_id = $request->get('country_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $db->save();
            }

        } catch (Throwable $ex) {
            return $ex;
        }

        return redirect("states");
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return redirect("states");
    }
}
