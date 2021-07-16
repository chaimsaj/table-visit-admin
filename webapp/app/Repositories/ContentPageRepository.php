<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ContentPage;
use App\Models\Favorite;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class ContentPageRepository extends BaseRepository implements ContentPageRepositoryInterface
{
    public function __construct(ContentPage $model)
    {
        parent::__construct($model);
    }

    public function actives(): Collection
    {
        return $this->model->all('active', 1);
    }

    public function published(): Collection
    {

    }
}
