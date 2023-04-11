<?php

namespace App\Service;

use App\Repository\TripRepositoryInterface;
use App\Service\BaseService;

class TripService extends BaseService
{
    protected $repo;
    public function __construct(TripRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    public function allTrips($columns , $relations)
    {
        return $this->repo->all($columns , $relations);
    }
}
