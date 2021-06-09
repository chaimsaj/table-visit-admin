<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\State;
use App\Services\StateServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatesController extends AdminController
{
    private $service;

    public function __construct(StateServiceInterface $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->all();
        return view('states/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        return view('states/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('states/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new State();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('iso_code'));
                $db->country_id = 0;

                $db->save();
            }

        } catch (Throwable $ex) {
            return $ex;
        }

        return redirect("states");
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return redirect("states");
    }
}
