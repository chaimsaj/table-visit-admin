<?php


namespace App\Repositories;

use App\Models\City;
use App\Models\ServiceRate;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\UserToPlace;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;

class UserToPlaceRepository extends BaseRepository implements UserToPlaceRepositoryInterface
{
    public function __construct(UserToPlace $model)
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
