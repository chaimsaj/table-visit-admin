<?php

namespace App\Http\Controllers;

use App\Repositories\LogRepositoryInterface;
use Illuminate\Routing\Controller as BaseController;

class LogController extends BaseController
{
    private LogRepositoryInterface $repository;

    public function __construct(LogRepositoryInterface $repository)
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

    public function truncate()
    {
        $this->repository->truncate();
        return redirect("logs");
    }
}
