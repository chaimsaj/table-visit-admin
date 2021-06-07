<?php


namespace App\Services;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

interface StateServiceInterface
{
    public function find($id): ?State;
    public function all(): Collection;
    public function delete($id): bool;
}
