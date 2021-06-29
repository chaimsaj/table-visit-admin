<?php


namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class CurrencyRepository extends BaseRepository implements CurrencyRepositoryInterface
{
    public function __construct(Currency $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->all('active', 1);
    }

    public function published(): Collection
    {
        return $this->model->all('active', 1)
            ->where('published', 1);
    }
}
