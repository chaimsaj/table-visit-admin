<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\ServiceType;
use App\Repositories\ServiceRateRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class ServiceRatesController extends AdminController
{
    private ServiceRateRepositoryInterface $serviceRateRepository;

    public function __construct(ServiceRateRepositoryInterface $serviceRateRepository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->serviceRateRepository = $serviceRateRepository;
    }

    public function index()
    {
        $data = $this->serviceRateRepository->actives();
        return view('service-rates/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->serviceRateRepository->find($id);
        return view('service-rates/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->serviceRateRepository->find($id);

            if ($validator->fails() && $db == null) {
                return view('service-rates/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new ServiceType();

                $db->name = $request->get('name');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $this->serviceRateRepository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("service-rates");
    }

    public function delete($id)
    {
        $this->serviceRateRepository->deleteLogic($id);

        return redirect("service-rates");
    }
}
