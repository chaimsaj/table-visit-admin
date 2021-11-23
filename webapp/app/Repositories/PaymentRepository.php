<?php


namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }

    public function loadByBooking(int $booking_id): Collection
    {
        return $this->model->where('deleted', '=', 0)
            ->where('published', '=', 1)
            ->where('booking_id', '=', $booking_id)
            ->orderBy('date')
            ->get();
    }
}
