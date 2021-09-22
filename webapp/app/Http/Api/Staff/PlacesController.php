<?php

namespace App\Http\Api\Staff;

use App\Http\Api\Base\ApiController;
use App\Repositories\PlaceRepositoryInterface;
use App\Services\LogServiceInterface;

class PlacesController extends ApiController
{
    private PlaceRepositoryInterface $placeRepository;

    public function __construct(PlaceRepositoryInterface $placeRepository,
                                LogServiceInterface      $logger)
    {
        parent::__construct($logger);

        $this->placeRepository = $placeRepository;
    }
}
