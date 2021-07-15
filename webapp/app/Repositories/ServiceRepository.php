<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class ServiceRepository extends BaseRepository implements ServiceRepositoryInterface
{
    public function __construct(Service $model)
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
