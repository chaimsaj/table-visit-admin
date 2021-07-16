<?php


namespace App\Repositories;

use App\Models\SystemConfiguration;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class SystemConfigurationRepository extends BaseRepository implements SystemConfigurationRepositoryInterface
{
    public function __construct(SystemConfiguration $model)
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
