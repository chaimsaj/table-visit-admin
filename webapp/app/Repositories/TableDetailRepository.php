<?php


namespace App\Repositories;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\TableDetail;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TableDetailRepository extends BaseRepository implements TableDetailRepositoryInterface
{
    public function __construct(TableDetail $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $table_id, int $language_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('table_id', $table_id)
            ->where('language_id', $language_id)
            ->first();
    }
}
