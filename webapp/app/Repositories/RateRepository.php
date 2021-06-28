<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\Rate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class RateRepository extends BaseRepository implements RateRepositoryInterface
{
    public function __construct(Rate $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->all('active', 1);
    }

    public function published(): Collection
    {

    }
}
