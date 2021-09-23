<?php

namespace App\Http\Controllers;

use App\Core\CommissionTypeEnum;
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
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                return view('commissions/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Commission();

                $db->percentage = floatval($request->get('percentage'));
                $db->rate = floatval($request->get('rate'));
                $db->commission_type = CommissionTypeEnum::Undefined;
                $db->min_rate = floatval($request->get('min_rate'));
                $db->max_rate = floatval($request->get('max_rate'));
                $db->published = $request->get('published') == "on";
                $db->deleted = 0;

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
