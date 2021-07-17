<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\BookingRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class BookingsController extends AdminController
{
    private BookingRepositoryInterface $repository;

    public function __construct(BookingRepositoryInterface $repository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);
        $this->repository = $repository;
    }

    public function index()
    {
        return view('bookings/index');
    }

    public function detail()
    {
        return view('bookings/detail');
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
