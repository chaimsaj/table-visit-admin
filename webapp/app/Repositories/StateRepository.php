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
        return $this->model->all('active', 1);
    }

    public function published(): Collection
    {
        return $this->model->all('active', 1)
            ->where('published', 1);
    }
}
