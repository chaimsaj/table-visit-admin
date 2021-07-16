<?php


namespace App\Services;


use App\Models\Booking;
use App\Models\UserToPlace;
use Illuminate\Database\Eloquent\Collection;

interface UserToPlaceServiceInterface
{
    public function find($id): ?UserToPlace;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
