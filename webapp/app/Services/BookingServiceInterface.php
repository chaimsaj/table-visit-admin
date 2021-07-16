<?php


namespace App\Services;


use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;

interface BookingServiceInterface
{
    public function find($id): ?Booking;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
