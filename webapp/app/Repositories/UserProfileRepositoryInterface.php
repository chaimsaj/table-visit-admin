<?php


namespace App\Repositories;


use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface UserProfileRepositoryInterface extends BaseRepositoryInterface
{
    public function loadByUser(int $user_id): ?Model;
}
