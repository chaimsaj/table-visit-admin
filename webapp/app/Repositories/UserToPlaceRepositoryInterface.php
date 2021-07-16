<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface UserToPlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function actives(): Collection;
    public function published(): Collection;
}