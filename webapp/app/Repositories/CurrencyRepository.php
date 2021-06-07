<?php


namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Base\BaseRepository;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }
}
