<?php


namespace App\Repositories;

use App\Models\Policy;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class PolicyRepository extends BaseRepository implements PolicyRepositoryInterface
{
    public function __construct(Policy $model)
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
