<?php

namespace App\Http\Controllers;

use App\Core\AuthModeEnum;
use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\BasicController;
use App\Models\Country;
use App\Services\CountryServiceInterface;
use App\Services\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CountriesController extends BasicController
{
    private $service;

    public function __construct(CountryServiceInterface $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }

    public function index()
    {
        return view('countries/index');
    }

    public function detail($id)
    {
        $data = $this->service->find($id);

        return view('countries/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        $db = null;

        try {

            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                //'iso_code' => ['required', 'string', 'iso_code', 'max:255', 'unique:countries'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('countries/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Country();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('iso_code'));

                $db->save();
            }

        } catch (Throwable $ex) {
            return $ex;
        }

        return redirect("countries");
    }

    public function delete($id)
    {
        $this->service->delete($id);

        return redirect("countries");
    }

    /*public function save(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }*/
}
