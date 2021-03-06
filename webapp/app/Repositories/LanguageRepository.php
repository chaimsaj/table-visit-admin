<?php


namespace App\Repositories;

use App\Models\Currency;
use App\Models\Language;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Throwable;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    public function __construct(Language $model)
    {
        parent::__construct($model);
    }
}
