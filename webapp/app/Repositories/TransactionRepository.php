<?php


namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Base\BaseRepository;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }
}
