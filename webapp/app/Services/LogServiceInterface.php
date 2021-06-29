<?php


namespace App\Services;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Log;
use Illuminate\Database\Eloquent\Collection;

interface LogServiceInterface
{
    public function find($id): ?Log;
    public function all(): Collection;
    public function delete($id): bool;
    public function actives(): Collection;
    public function published(): Collection;
    public function deleteLogic($id): bool;
}
