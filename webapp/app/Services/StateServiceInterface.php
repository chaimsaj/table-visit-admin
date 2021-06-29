<?php


namespace App\Services;

use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

interface StateServiceInterface
{
    public function find($id): ?State;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function publishedByCountry($country_id): Collection;
}
