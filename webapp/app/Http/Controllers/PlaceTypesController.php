<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\PlaceType;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PlaceTypesController extends AdminController
{
    private PlaceTypeRepositoryInterface $placeTypeRepository;

    public function __construct(PlaceTypeRepositoryInterface $placeTypeRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->placeTypeRepository = $placeTypeRepository;
    }

    public function index()
    {
        $data = $this->placeTypeRepository->actives();
        return view('place-types/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->placeTypeRepository->find($id);
        return view('place-types/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->placeTypeRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('place-types/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new PlaceType();

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
