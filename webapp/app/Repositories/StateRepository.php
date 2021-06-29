<?php


namespace App\Repositories;

use App\Models\State;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class StateRepository extends BaseRepository implements StateRepositoryInterface
{
    public function __construct(State $model)
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

    public function publishedByCountry($country_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('country_id', $country_id)
            ->get();
    }

    public function deleteLogic($id): bool
    {
        try {

            $model = $this->find($id);

            if ($model != null) {
                $model->published = 0;
                $model->show = 0;
                $model->deleted = 1;

                $model->save();
            }

            return true;
        } catch (Throwable $ex) {
            return false;
        }
    }
}
