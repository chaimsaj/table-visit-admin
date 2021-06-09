<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\BasicController;
use App\Services\CurrencyServiceInterface;
use App\Services\UserServiceInterface;
use Illuminate\Http\Request;

class CurrenciesController extends BasicController
{
    private $service;

    public function __construct(CurrencyServiceInterface $service)
    {
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
