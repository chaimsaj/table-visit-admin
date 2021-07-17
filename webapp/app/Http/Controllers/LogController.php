<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Services\LogServiceInterface;

class LogController extends BaseController
{
    private LogServiceInterface $service;

    public function __construct(LogServiceInterface $service)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->actives();
        return view('logs/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        return view('logs/detail', ["data" => $data]);
    }

    public function delete($id)
    {
        $this->repository->delete($id);

        return redirect("logs");
    }
}
