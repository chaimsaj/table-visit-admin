<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class TablesController extends AdminController
{
    private TableRepositoryInterface $tableRepository;

    public function __construct(TableRepositoryInterface $tableRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->tableRepository = $tableRepository;
    }

    public function index()
    {
        return view('tables/index');
    }

    public function detail()
    {
        return view('tables/detail');
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
