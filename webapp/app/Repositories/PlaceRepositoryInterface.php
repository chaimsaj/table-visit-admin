<?php


namespace App\Repositories;

use App\Core\LanguageEnum;
use App\Repositories\Base\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function publishedByCity(int $city_id, int $language_id = LanguageEnum::English): Collection;

    public function featured(int $top = 25): Collection;

    public function near(int $top = 25): Collection;

    public function search(string $search, int $top = 25): Collection;

    public function activesByTenant(int $tenant_id): Collection;
}
