<?php


namespace App\Repositories;

use App\Models\Commission;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CommissionRepository extends BaseRepository implements CommissionRepositoryInterface
{
    public function __construct(Commission $model)
    {
        parent::__construct($model);
    }

    public function loadByPlace(int $place_id): ?Model
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('place_id', '=', $place_id)
            ->first();
    }
}
