<?php


namespace App\Services;

use App\Models\User;

interface UserServiceInterface
{
    public function find($id): ?User;
}
