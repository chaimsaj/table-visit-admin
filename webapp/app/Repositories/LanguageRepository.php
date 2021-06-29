<?php


namespace App\Repositories;

use App\Models\Currency;
use App\Models\Language;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->where('deleted', 0)->get();
    }

    public function published(): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->get();
    }
}
