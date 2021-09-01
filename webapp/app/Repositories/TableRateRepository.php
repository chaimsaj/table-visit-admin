<?php


namespace App\Repositories;

use App\Models\TableRate;
use DateTime;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TableRateRepository extends BaseRepository implements TableRateRepositoryInterface
{
    public function __construct(TableRate $model)
    {
        parent::__construct($model);
    }

    public function loadByTable(int $table_id): Collection
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('table_id', '=', $table_id)
            ->get();
    }

    public function firstByTable(int $table_id): ?Model
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('table_id', '=', $table_id)
            ->first();
    }

    public function rate(int $table_id, DateTime $date): ?Model
    {
        return $this->model->where('published', '=', 1)
            ->where('show', '=', 1)
            ->where('deleted', '=', 0)
            ->where('table_id', '=', $table_id)
            ->whereDate("valid_from", "<=", $date)
            ->where(function ($query) use ($date) {
                $query->whereDate("valid_to", ">=", $date)
                    ->orWhereDate('valid_to', "=", null);
            })->orderBy('id', 'desc')->first();
    }
}
