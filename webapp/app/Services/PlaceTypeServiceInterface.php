<?php


namespace App\Services;

use App\Models\PlaceType;
use Illuminate\Database\Eloquent\Collection;

interface PlaceTypeServiceInterface
{
    public function find($id): ?PlaceType;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
