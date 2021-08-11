<?php

namespace App\Http\Controllers\Base;

use App\Core\UserTypeEnum;
use App\Services\LogServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LogServiceInterface $logger;

    public function __construct(LogServiceInterface $logger)
    {
        $this->middleware('auth');
        $this->logger = $logger;

        /*if (Auth::user()->user_type_id != UserTypeEnum::Admin &&
            Auth::user()->user_type_id != UserTypeEnum::PlaceAdmin)
                Auth::logout();*/
    }
}
