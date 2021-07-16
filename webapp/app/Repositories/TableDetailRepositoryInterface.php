<?php


namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface TableDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function actives(): Collection;

    public function published(): Collection;

    public function deleteLogic($id): bool;
}
