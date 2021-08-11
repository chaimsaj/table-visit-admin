<?php

namespace App\Http\Controllers;

use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\PlaceType;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PlaceTypesController extends AdminController
{
    private PlaceTypeRepositoryInterface $placeTypeRepository;

    public function __construct(PlaceTypeRepositoryInterface $placeTypeRepository,
                                LogServiceInterface          $logger)
    {
        parent::__construct($logger);

        $this->placeTypeRepository = $placeTypeRepository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $data = $this->placeTypeRepository->actives();
        else
            $data = $this->placeTypeRepository->activesByTenant(Auth::user()->tenant_id);

        return view('place-types/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->placeTypeRepository->find($id);

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        return view('place-types/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->placeTypeRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('place-types/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new PlaceType();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->placeTypeRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("place-types");
    }

    public function delete($id)
    {
        $this->placeTypeRepository->deleteLogic($id);

        return redirect("place-types");
    }
}
