<?php


namespace App\Repositories;

use App\Model\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function all(): Collection;
}
