<?php


namespace App\Repositories;

use App\Models\Table;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class TableRepository extends BaseRepository implements TableRepositoryInterface
{
    public function __construct(Table $model)
    {
        parent::__construct($model);
    }

    public function loadByPlace(int $place_id): Collection
    {
        // $table_status = TableStatusEnum::Available;
        // ->where('table_status', '=', $table_status)

        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('place_id', '=', $place_id)
            ->get();
    }
}
