<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CommissionRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByPlace(int $place_id): ?Model;
}
