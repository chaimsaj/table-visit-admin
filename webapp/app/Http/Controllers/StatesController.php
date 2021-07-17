<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Http\Controllers\Base\AdminController;
use App\Models\State;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\StateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class StatesController extends AdminController
{
    private StateRepositoryInterface $repository;
    private CountryRepositoryInterface $countryRepository;

    public function __construct(StateRepositoryInterface $repository,
                                CountryRepositoryInterface $countryRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->countryRepository = $countryRepository;
    }

    public function index()
    {
        $data = $this->repository->actives();

        $data->each(function ($item, $key) {
            $country = $this->countryRepository->find($item->country_id);
            if ($country)
                $item->country_name = $country->name;
            else
                $item->country_name = AppConstant::getDash();
        });

        return view('states/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        $countries = $this->countryRepository->published();
        return view('states/detail', ["data" => $data, "countries" => $countries]);
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
            $this->logger->save($ex);
        }

        return redirect("states");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);
        return redirect("states");
    }
}
