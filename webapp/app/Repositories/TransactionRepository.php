<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\Favorite;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\Transaction;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class TransactionRepository extends BaseRepository implements TransactionRepositoryInterface
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->all('active', 1);
    }

    public function published(): Collection
    {

    }
}
