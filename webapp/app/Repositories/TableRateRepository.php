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
}
