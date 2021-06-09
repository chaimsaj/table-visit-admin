<?php


namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Base\BaseRepository;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    public function __construct(Payment $model)
    {
        parent::__construct($model);
    }
}
