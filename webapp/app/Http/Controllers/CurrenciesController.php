<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Http\Controllers\Base\BasicController;
use App\Services\CurrencyServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class CurrenciesController extends AdminController
{
    private CurrencyServiceInterface $service;

    public function __construct(CurrencyServiceInterface $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function index()
    {
        return view('currencies/index');
    }

    public function detail()
    {
        return view('currencies/detail');
    }

    public function save(Request $request, $id)
    {
        //
    }

    public function delete($id)
    {
        //
    }
}
