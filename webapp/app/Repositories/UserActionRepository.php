<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\TableDetail;
use App\Models\TableRate;
use App\Models\TableType;
use App\Models\UserAction;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class UserActionRepository extends BaseRepository implements UserActionRepositoryInterface
{
    public function __construct(UserAction $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->where('deleted', 0)->get();
    }

    public function published(): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->get();
    }

    public function deleteLogic($id): bool
    {
        try {

            $model = $this->find($id);

            if ($model != null) {
                $model->published = 0;
                $model->deleted = 1;

                $model->save();
            }

            return true;
        } catch (Throwable $ex) {
            return false;
        }
    }
}
