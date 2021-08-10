<?php


namespace App\Repositories;

use App\Models\TableRate;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TableRateRepository extends BaseRepository implements TableRateRepositoryInterface
{
    public function __construct(TableRate $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $table_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('table_id', $table_id)
            ->get();
    }
}
