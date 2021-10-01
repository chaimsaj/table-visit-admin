<?php


namespace App\Repositories;

use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface extends BaseRepositoryInterface
{
    public function userBookings($user_id): Collection;

    public function activesPaged(int $start, int $length, string $order_by, string $order, string $search): array;

    public function activesPagedByTenant(int $tenant_id, int $start, int $length, string $order_by, string $order, string $search): array;

    public function staffSearch(string $search, int $place_id): Collection;
}
