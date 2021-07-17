<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\AdminController;
use App\Models\UserToPlace;
use App\Repositories\UserToPlaceRepositoryInterface;
use App\Services\LogServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserToPlacesController extends AdminController
{
    private UserToPlaceRepositoryInterface $repository;

    public function __construct(UserToPlaceRepositoryInterface $repository,
                                LogServiceInterface $logger)
    {
        parent::__construct($logger);

        $this->repository = $repository;
    }

    public function save(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'int'],
                'place_id' => ['required', 'int'],
            ]);

            $db = $this->repository->find($id);

            if ($validator->fails() && $db == null) {
                // return view('states/detail', ["data" => $request])->withErrors($validator);
            } else {
                if ($db == null)
                    $db = new UserToPlace();

                $db->user_id = $request->get('user_id');
                $db->place_id = $request->get('place_id');
                $db->published = $request->get('published') == "on";

                $this->repository->save($db);
            }

        } catch (Throwable $ex) {
            $this->logger->save($ex);
        }

        return redirect("users");
    }

    public function delete($id)
    {
        $this->repository->deleteLogic($id);
        return redirect("users");
    }
}
