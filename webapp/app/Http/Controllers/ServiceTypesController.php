<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\ServiceType;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServiceTypesController extends AdminController
{
    private ServiceTypeRepositoryInterface $serviceTypeRepository;

    public function __construct(ServiceTypeRepositoryInterface $serviceTypeRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->serviceTypeRepository = $serviceTypeRepository;
    }

    public function index()
    {
        $data = $this->serviceTypeRepository->actives();
        return view('service-types/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->serviceTypeRepository->find($id);
        return view('service-types/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->serviceTypeRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('service-types/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new ServiceType();

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->serviceTypeRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("service-types");
    }

    public function delete($id)
    {
        $this->serviceTypeRepository->deleteLogic($id);

        return redirect("service-types");
    }
}
