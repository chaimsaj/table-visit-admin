<?php


namespace App\Http\AdminApi\Base;

use App\Services\LogServiceInterface;
use App\Services\UserServiceInterface;
use App\Services\UserToPlaceServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AdminApiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected LogServiceInterface $logger;
    protected UserServiceInterface $userService;
    protected UserToPlaceServiceInterface $userToPlaceService;

    public function __construct(LogServiceInterface $logger,
                                UserServiceInterface $userService,
                                UserToPlaceServiceInterface $userToPlaceService)
    {
        $this->middleware('auth');
        $this->logger = $logger;
        $this->userService = $userService;
        $this->userToPlaceService = $userToPlaceService;
    }
}
