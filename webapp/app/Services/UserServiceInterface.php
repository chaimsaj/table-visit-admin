<?php


namespace App\Services;

use App\Models\User;
use http\Message;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function editUser(Request $request, $id): Message;
    public function find($id): ?User;
    public function all(): Collection;
}
