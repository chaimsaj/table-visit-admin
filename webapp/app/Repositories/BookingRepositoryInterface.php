<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use DateTime;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface extends BaseRepositoryInterface
{
    public function userActiveBookings(int $user_id): Collection;

    public function userPastBookings(int $user_id, int $length = 10): Collection;

    public function activesPaged(int $start, int $length, string $order_by, string $order, string $search): array;

    public function activesPagedByTenant(int $tenant_id, int $start, int $length, string $order_by, string $order, string $search): array;

    // Staff
    public function inboxStaff(int $place_id, int $user_type_id, string $search = null): Collection;

    public function assignedStaff(int $user_id, string $search = null): Collection;

    //Report
    public function tableSpendsReport(DateTime $date_from, DateTime $date_to, int $place_id): Collection;

}
