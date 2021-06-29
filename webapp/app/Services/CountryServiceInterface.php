<?php


namespace App\Services;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

interface CountryServiceInterface
{
    public function find($id): ?Country;

    public function all(): Collection;

    public function delete($id): bool;

    public function actives(): Collection;

    public function published(): Collection;
    public function deleteLogic($id): bool;
}
