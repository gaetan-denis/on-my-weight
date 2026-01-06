<?php

namespace OnTheWeight\services;

use OnTheWeight\repositories\WeightRepository;
use RuntimeException;

class WeightService
{
    public function __construct(
        private WeightRepository $repo
    ) {
    }
    public function addWeight(int $userId, float $weight)
    {
        if ($weight <= 0) {
            throw new RuntimeException("Weight must be positive.");
        }
        $this->repo->createWeight($userId, $weight);
    }

    /**
    * @param int $userId
    * @return \OnTheWeight\entities\Weight[]
    */
    public function getWeightsById(int $userId): array
    {
        return $this->repo->getAllWeightsByUser($userId);
    }
}
