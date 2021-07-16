<?php


namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface SystemConfigurationRepositoryInterface extends BaseRepositoryInterface
{
    public function actives(): Collection;
    public function published(): Collection;
}
