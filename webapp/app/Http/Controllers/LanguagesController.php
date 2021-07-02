<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\Language;
use App\Services\LanguageServiceInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class LanguagesController extends AdminController
{
    private LanguageServiceInterface $service;

    public function __construct(LanguageServiceInterface $service,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->service = $service;
    }

    public function index()
    {
        $data = $this->service->actives();
        return view('languages/index', ["data" => $data]);
    }

    public function detail($id)
    {
        $data = $this->service->find($id);
        return view('languages/detail', ["data" => $data]);
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
            ]);

            $db = $this->service->find($id);

            if ($validator->fails() && $db == null) {
                return view('languages/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new Language();

                $db->name = $request->get('name');
                $db->iso_code = $request->get('iso_code');
                $db->display_order = intval($request->get('display_order'));
                $db->published = $request->get('published') == "on";
                $db->show = $request->get('show') == "on";

                $db->save();
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("languages");
    }

    public function delete($id)
    {
        $this->service->deleteLogic($id);

        return redirect("languages");
    }
}
