<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\Service;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServicesController extends AdminController
{
    private ServiceRepositoryInterface $serviceRepository;
    private ServiceTypeRepositoryInterface $serviceTypeRepository;
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(ServiceRepositoryInterface     $serviceRepository,
                                ServiceTypeRepositoryInterface $serviceTypeRepository,
                                PlaceRepositoryInterface       $placeRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->serviceRepository = $serviceRepository;
        $this->serviceTypeRepository = $serviceTypeRepository;
        $this->placeRepository = $placeRepository;
    }

    public function index()
    {
        return view('services/index');
    }

    public function detail($id)
    {
        $data = $this->serviceRepository->find($id);
        $service_types = $this->serviceTypeRepository->published();
        $places = $this->placeRepository->published();

        return view('services/detail', ["data" => $data, "service_types" => $service_types, "places" => $places]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'display_order' => ['required', 'int'],
            ]);

            $db = $this->serviceRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('services/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Service();

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->service_type_id = $request->get('service_type_id');
                $db->place_id = $request->get('place_id');
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->serviceRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("services");
    }

    public function delete($id)
    {
        $this->serviceRepository->deleteLogic($id);
        return redirect("services");
    }
}
