<?php

namespace App\Http\Controllers;

use App\Core\AuthModeEnum;
use App\Core\UserTypeEnum;
use App\Http\Controllers\Base\AdminController;
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

class CountriesController extends AdminController
{
    private $service;

    public function __construct(CountryServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->all();
        return view('countries/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        return view('countries/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('countries/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Country();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('display_order'));

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
