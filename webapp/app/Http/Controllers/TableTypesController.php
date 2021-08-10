<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;

class TableTypesController extends AdminController
{
    private TableTypeRepositoryInterface $tableTypeRepository;

    public function __construct(TableTypeRepositoryInterface $tableTypeRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->tableTypeRepository = $tableTypeRepository;
    }

    public function index()
    {
        return view('table-types/index');
    }

    public function detail()
    {
        return view('table-types/detail');
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
