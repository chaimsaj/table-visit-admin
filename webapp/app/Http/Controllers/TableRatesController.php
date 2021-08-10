<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableRateRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class TableRatesController extends AdminController
{
    private TableRateRepositoryInterface $tableRateRepository;

    public function __construct(TableRateRepositoryInterface $tableRateRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->tableRateRepository = $tableRateRepository;
    }

    public function index()
    {
        return view('table-rates/index');
    }

    public function detail()
    {
        return view('table-rates/detail');
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
