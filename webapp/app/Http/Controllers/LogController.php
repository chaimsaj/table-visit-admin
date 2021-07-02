<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\LogServiceInterface;

class LogController extends BaseController
{
    private LogServiceInterface $service;

    public function __construct(LogServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->actives();
        return view('logs/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        return view('logs/detail', ["data" => $data]);
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return redirect("logs");
    }
}
