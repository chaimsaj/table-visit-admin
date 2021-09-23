<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\Commission;
use App\Repositories\CommissionRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommissionsController extends AdminController
{
    private CommissionRepositoryInterface $repository;

    public function __construct(CommissionRepositoryInterface $repository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->actives();
        return view('commissions/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        return view('commissions/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                return view('commissions/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Commission();

                $this->repository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("commissions");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);

        return redirect("commissions");
    }
}
