<?php


namespace App\Repositories;

use App\Models\TableSpend;
use App\Repositories\Base\BaseRepository;

class TableSpendRepository extends BaseRepository implements TableSpendRepositoryInterface
{
    public function __construct(TableSpend $model)
    {
        parent::__construct($model);
    }
}
