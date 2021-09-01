<?php


namespace App\Repositories;

use App\Models\Policy;
use App\Repositories\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class PolicyRepository extends BaseRepository implements PolicyRepositoryInterface
{
    public function __construct(Policy $model)
    {
        parent::__construct($model);
    }

    public function loadBy(int $place_id, int $policy_type, int $language_id): ?Model
    {
        return $this->model->where('deleted', 0)
            ->where('published', 1)
            ->where('place_id', $place_id)
            ->where('policy_type', $policy_type)
            ->where('language_id', $language_id)
            ->first();
    }
}
