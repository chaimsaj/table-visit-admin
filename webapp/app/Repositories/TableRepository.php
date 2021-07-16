<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Table;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class TableRepository extends BaseRepository implements TableRepositoryInterface
{
    public function __construct(Table $model)
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
