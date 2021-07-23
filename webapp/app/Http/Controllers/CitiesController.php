<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Http\Controllers\Base\AdminController;
use App\Models\City;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CitiesController extends AdminController
{
    private CityRepositoryInterface $repository;
    private CountryRepositoryInterface $countryRepository;
    private StateRepositoryInterface $stateRepository;

    public function __construct(CityRepositoryInterface $repository,
                                CountryRepositoryInterface $countryRepository,
                                StateRepositoryInterface $stateRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
    }

    public function index()
    {
        $data = $this->repository->actives()->take(250);

        $data->each(function ($item, $key) {
            $country = $this->countryRepository->find($item->country_id);

            if ($country)
                $item->country_name = $country->name;
            else
                $item->country_name = AppConstant::getDash();

            $state = $this->stateRepository->find($item->state_id);

            if ($state)
                $item->state_name = $state->name;
            else
                $item->state_name = AppConstant::getDash();
        });

        return view('cities/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        $countries = $this->countryRepository->published();
        $states = new Collection();

        if ($data != null)
            $states = $this->stateRepository->publishedByCountry($data->country_id);

        return view('cities/detail', ["data" => $data, "countries" => $countries, "states" => $states]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'display_order' => ['required', 'int'],
            ]);

            $db = $this->repository->find($id);

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

                $this->repository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("cities");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);
        return redirect("cities");
    }
}
