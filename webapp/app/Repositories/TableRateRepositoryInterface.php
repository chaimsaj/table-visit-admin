<?php


namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TableRateRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByTable(int $table_id): Collection;

    public function firstByTable(int $table_id): ?Model;

    public function rate(int $table_id, DateTime $date): ?Model;
}
