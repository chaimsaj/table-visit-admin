<?php

namespace App\Http\Controllers;

use App\Core\AppConstant;
use App\Core\FeeTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\Currency;
use App\Models\Fee;
use App\Repositories\FeeRepositoryInterface;
use App\Repositories\PlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class FeesController extends AdminController
{
    private FeeRepositoryInterface $repository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(FeeRepositoryInterface   $repository,
                                PlaceRepositoryInterface $placeRepository,
                                LogServiceInterface      $logger)
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

        return view('fees/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->repository->find($id);
        $places = $this->placeRepository->published();

        return view('fees/detail',
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
                return view('fees/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Fee();

                $db->percentage = floatval($request->get('percentage'));
                $db->rate = floatval($request->get('rate'));
                $db->fee_type = FeeTypeEnum::Undefined;
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

        return redirect("fees");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);

        return redirect("fees");
    }
}
