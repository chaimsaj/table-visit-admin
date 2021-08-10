<?php


namespace App\Repositories;

use App\Models\BookingTable;
use App\Repositories\Base\BaseRepository;

class BookingTableRepository extends BaseRepository implements BookingTableRepositoryInterface
{
    public function __construct(BookingTable $model)
    {
        parent::__construct($model);
    }
}
