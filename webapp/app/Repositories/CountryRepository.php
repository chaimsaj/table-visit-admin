<?php


namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Base\BaseRepository;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    public function __construct(Country $model)
    {
        parent::__construct($model);
    }
}
