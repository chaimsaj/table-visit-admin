<?php


namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TableDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function loadBy(int $table_id, int $language_id): ?Model;
}
