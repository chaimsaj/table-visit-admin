<?php


namespace App\Services;

use App\Models\Place;
use App\Models\PlaceType;
use Illuminate\Database\Eloquent\Collection;

interface PlaceServiceInterface
{
    public function find($id): ?Place;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
