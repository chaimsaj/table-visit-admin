<?php


namespace App\Services;

use App\Models\Country;

interface CountryServiceInterface
{
    public function find($id): ?Country;
}
