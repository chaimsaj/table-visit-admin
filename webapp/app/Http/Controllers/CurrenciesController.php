<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\Currency;
use App\Services\CurrencyServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CurrenciesController extends AdminController
{
    private CurrencyServiceInterface $service;

    public function __construct(CurrencyServiceInterface $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->actives();
        return view('currencies/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        return view('currencies/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('currencies/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Currency();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $db->save();
            }

        } catch (Throwable $ex) {
            return $ex;
        }

        return redirect("currencies");
    }

    public function delete($id)
    {
        $this->service->deleteLogic($id);

        return redirect("currencies");
    }
}
