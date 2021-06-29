<?php


namespace App\Services;

use App\Models\Country;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Collection;

interface CurrencyServiceInterface
{
    public function find($id): ?Currency;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;

    public function published(): Collection;
}
