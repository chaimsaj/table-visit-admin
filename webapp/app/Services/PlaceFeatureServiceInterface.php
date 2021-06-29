<?php


namespace App\Services;

use App\Models\PlaceFeature;
use Illuminate\Database\Eloquent\Collection;

interface PlaceFeatureServiceInterface
{
    public function find($id): ?PlaceFeature;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
