<?php


namespace App\Repositories;

use App\Models\TableRate;
use App\Repositories\Base\BaseRepository;

class TableRateRepository extends BaseRepository implements TableRateRepositoryInterface
{
    public function __construct(TableRate $model)
    {
        parent::__construct($model);
    }
}
