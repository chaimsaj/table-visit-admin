<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use App\Services\CityServiceInterface;
use App\Services\StateServiceInterface;
use Illuminate\Http\Request;

class CitiesController extends BasicController
{
    private CityServiceInterface $service;

    public function __construct(CityServiceInterface $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->all();
        return view('cities/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        return view('cities/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return redirect("cities");
    }
}
