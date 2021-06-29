<?php


namespace App\Repositories;

use App\Models\Country;
use App\Models\PlaceFeature;
use App\Models\PlaceMusic;
use App\Models\PlaceType;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Collection;
use Throwable;

class PlaceMusicRepository extends BaseRepository implements PlaceMusicRepositoryInterface
{
    public function __construct(PlaceMusic $model)
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

    public function deleteLogic($id): bool
    {
        try {

            $model = $this->find($id);

            if ($model != null) {
                $model->published = 0;
                $model->show = 0;
                $model->deleted = 1;

                $model->save();
            }

            return true;
        } catch (Throwable $ex) {
            $this->logger->save($ex);
            return false;
        }
    }
}
