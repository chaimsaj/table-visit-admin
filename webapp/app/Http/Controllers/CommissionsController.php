<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Core\CommissionTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\Commission;
use App\Repositories\CommissionRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CommissionsController extends AdminController
{
    private CommissionRepositoryInterface $repository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(CommissionRepositoryInterface $repository,
                                PlaceRepositoryInterface      $placeRepository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
        $this->placeRepository = $placeRepository;
    }

    public function index()
    {
        $data = $this->repository->actives();

        $data->each(function ($item) {
            $place = null;

            if ($item->place_id > 0)
                $place = $this->placeRepository->find($item->place_id);

            if (isset($place))
                $item->place_name = $place->name;
            else
                $item->place_name = AppConstant::getAll();
        });

        return view('commissions/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        $places = $this->placeRepository->published();

        return view('commissions/detail',
            [
                "data" => $data,
                "places" => $places
            ]);
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
                $db->place_id = $request->get('place_id');
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
