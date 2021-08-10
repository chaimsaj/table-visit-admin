<?php


namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Throwable;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
