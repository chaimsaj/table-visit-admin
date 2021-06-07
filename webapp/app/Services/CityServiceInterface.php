<?php


namespace App\Services;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

interface CityServiceInterface
{
    public function find($id): ?City;
    public function all(): Collection;
    public function delete($id): bool;
}
