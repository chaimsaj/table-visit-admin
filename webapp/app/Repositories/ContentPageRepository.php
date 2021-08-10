<?php


namespace App\Repositories;

use App\Models\ContentPage;
use App\Repositories\Base\BaseRepository;

class ContentPageRepository extends BaseRepository implements ContentPageRepositoryInterface
{
    public function __construct(ContentPage $model)
    {
        parent::__construct($model);
    }
}
