<?php


namespace App\Repositories;

use App\Models\PlaceToMusic;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlaceToMusicRepository extends BaseRepository implements PlaceToMusicRepositoryInterface
{
    public function __construct(PlaceToMusic $model)
    {
        parent::__construct($model);
    }

    public function findByPlace($place_id): Collection
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->get();
    }

    public function existsByPlace($place_music_id, $place_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_music_id', $place_music_id)
            ->where('place_id', $place_id)
            ->first();
    }
}
