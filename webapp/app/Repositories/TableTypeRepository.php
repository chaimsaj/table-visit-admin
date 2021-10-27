<?php


namespace App\Repositories;

use App\Models\TableType;
use App\Repositories\Base\BaseRepository;

class TableTypeRepository extends BaseRepository implements TableTypeRepositoryInterface
{
    public function __construct(TableType $model)
    {
        parent::__construct($model);
    }
}
