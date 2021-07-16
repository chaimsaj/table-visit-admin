<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ServiceRate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class ServiceRateRepository extends BaseRepository implements ServiceRateRepositoryInterface
{
    public function __construct(ServiceRate $model)
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
