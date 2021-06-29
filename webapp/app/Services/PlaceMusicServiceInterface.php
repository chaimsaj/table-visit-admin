<?php


namespace App\Services;

use App\Models\PlaceMusic;
use Illuminate\Database\Eloquent\Collection;

interface PlaceMusicServiceInterface
{
    public function find($id): ?PlaceMusic;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
