<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function find($id): ?User;
    public function all(): Collection;
}
