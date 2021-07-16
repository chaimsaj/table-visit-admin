<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\PlaceWorkDay;
use App\Models\ServiceRate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class PlaceWorkDayRepository extends BaseRepository implements PlaceWorkDayRepositoryInterface
{
    public function __construct(PlaceWorkDay $model)
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
