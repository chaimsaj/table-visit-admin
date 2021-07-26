<?php


namespace App\Repositories;

use App\Models\Currency;
use App\Models\Guest;
use App\Models\Language;
use App\Models\Location;
use App\Repositories\Base\BaseRepository;

class GuestRepository extends BaseRepository implements GuestRepositoryInterface
{
    public function __construct(Guest $model)
    {
        parent::__construct($model);
    }
}
