<?php

namespace App\Http\Controllers\Base;

use App\Repositories\LogRepository;
use App\Repositories\LogRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LogRepositoryInterface $logger;

    public function __construct()
    {
        $this->middleware('auth');
        //$this->logger = new LogRepository();
    }
}
