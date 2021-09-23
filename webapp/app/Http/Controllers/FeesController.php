<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\Currency;
use App\Models\Fee;
use App\Repositories\FeeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FeesController extends AdminController
{
    private FeeRepositoryInterface $repository;

    public function __construct(FeeRepositoryInterface $repository,
                                LogServiceInterface    $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
    }

    public function index()
    {
        $data = $this->repository->actives();
        return view('fees/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        return view('fees/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                return view('fees/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Fee();

                $this->repository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("fees");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);

        return redirect("fees");
    }
}
