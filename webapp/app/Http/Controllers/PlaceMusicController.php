<?php

namespace App\Http\Controllers;

use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
use App\Models\PlaceMusic;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PlaceMusicController extends AdminController
{
    private PlaceMusicRepositoryInterface $repository;

    public function __construct(PlaceMusicRepositoryInterface $repository,
                                LogServiceInterface           $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $data = $this->repository->actives();
        else
            $data = $this->repository->activesByTenant(Auth::user()->tenant_id);

        return view('place-music/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->repository->find($id);

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        return view('place-music/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                return view('place-music/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new PlaceMusic();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->repository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("place-music-list");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);

        return redirect("place-music-list");
    }
}
