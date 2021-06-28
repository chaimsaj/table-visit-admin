<?php


namespace App\Repositories;

use App\Models\MediaFile;
use App\Repositories\Base\BaseRepository;

class MediaFileRepository extends BaseRepository implements MediaFileRepositoryInterface
{
    public function __construct(MediaFile $model)
    {
        parent::__construct($model);
    }
}
