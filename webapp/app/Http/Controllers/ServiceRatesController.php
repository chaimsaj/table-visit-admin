<?php

namespace App\Http\Controllers;

use App\Core\UserTypeEnum;
use App\Helpers\AppHelper;
use App\Http\Controllers\Base\AdminController;
use App\Models\Service;
use App\Models\ServiceRate;
use App\Models\ServiceType;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\ServiceRateRepositoryInterface;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\TenantRepositoryInterface;
use App\Services\LogServiceInterface;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class ServiceRatesController extends AdminController
{
    private ServiceRateRepositoryInterface $serviceRateRepository;
    private PlaceRepositoryInterface $placeRepository;
    private ServiceRepositoryInterface $serviceRepository;

    public function __construct(ServiceRateRepositoryInterface $serviceRateRepository,
                                PlaceRepositoryInterface       $placeRepository,
                                ServiceRepositoryInterface     $serviceRepository,
                                LogServiceInterface            $logger)
    {
        parent::__construct($logger);

        $this->serviceRateRepository = $serviceRateRepository;
        $this->placeRepository = $placeRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $data = $this->serviceRateRepository->actives();
        else
            $data = $this->serviceRateRepository->activesByTenant(Auth::user()->tenant_id);

        foreach ($data as $item) {
            $service = $this->serviceRepository->find($item->service_id);
            $place = $this->placeRepository->find($item->place_id);

            if (isset($service))
                $item->service_name = $service->name;

            if (isset($place))
                $item->place_name = $place->name;
        }

        return view('service-rates/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        if ($is_admin)
            $places = $this->placeRepository->actives();
        else
            $places = $this->placeRepository->activesByTenant(Auth::user()->tenant_id);

        if ($is_admin)
            $services = $this->serviceRepository->actives();
        else
            $services = $this->serviceRepository->activesByTenant(Auth::user()->tenant_id);

        $data = null;

        if ($id != 0)
            $data = $this->serviceRateRepository->find($id);

        if (isset($data)) {
            $data->valid_from_data = AppHelper::toDateString($data->valid_from, 'm-d-Y');
            $data->valid_to_data = AppHelper::toDateString($data->valid_to, 'm-d-Y');
        }

        if (isset($data) && !$is_admin && $data->tenant_id != Auth::user()->tenant_id)
            return redirect("/");

        return view('service-rates/detail', [
            "data" => $data,
            "places" => $places,
            "services" => $services,
            "is_admin" => $is_admin
        ]);
    }

    public function save(Request $request, $id)
    {
        try {
            $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

            $validator = Validator::make($request->all(), [
                'rate' => ['required', 'numeric'],
            ]);

            $db = $this->serviceRateRepository->find($id);

            if ($validator->fails() && $db == null) {
                if ($is_admin)
                    $places = $this->placeRepository->actives();
                else
                    $places = $this->placeRepository->activesByTenant(Auth::user()->tenant_id);

                if ($is_admin)
                    $services = $this->serviceRepository->actives();
                else
                    $services = $this->serviceRepository->activesByTenant(Auth::user()->tenant_id);

                return view('service-rates/detail',
                    [
                        "data" => $request,
                        "places" => $places,
                        "services" => $services,
                        "is_admin" => $is_admin
                    ])->withErrors($validator);
            } else {
                if ($db == null) {
                    $db = new ServiceRate();
                    if (!$is_admin)
                        $db->tenant_id = Auth::user()->tenant_id;
                }

                $db->rate = floatval($request->get('rate'));
                $db->tax = 0;
                $db->total_rate = $db->rate;
                $db->service_id = intval($request->get('service_id'));

                if (!empty($request->get('valid_from')))
                    $db->valid_from = DateTime::createFromFormat('m-d-Y H:i:s', $request->get('valid_from') . ' 00:00:00');
                else
                    $db->valid_from = null;

                if (!empty($request->get('valid_to')))
                    $db->valid_to = DateTime::createFromFormat('m-d-Y H:i:s', $request->get('valid_to') . ' 00:00:00');
                else
                    $db->valid_to = null;

                $db->place_id = intval($request->get('place_id'));
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
        $is_admin = Auth::user()->user_type_id == UserTypeEnum::Admin;

        $data = $this->serviceRateRepository->find($id);

        if (isset($data) && ($is_admin || $data->tenant_id == Auth::user()->tenant_id))
            $this->serviceRateRepository->deleteLogic($id);

        return redirect("service-rates");
    }
}
