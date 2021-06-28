<?php


namespace App\Services;

use App\Models\Language;
use App\Models\State;
use Illuminate\Database\Eloquent\Collection;

interface LanguageServiceInterface
{
    public function find($id): ?Language;
    public function all(): Collection;
    public function delete($id): bool;
}
