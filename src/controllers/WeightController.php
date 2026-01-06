<?php

namespace OnTheWeight\controllers;

use OnTheWeight\services\WeightService;
use RuntimeException;

class WeightController
{
    public function __construct(private WeightService $service)
    {
    }
    public function addWeight(): void
    {
        try {
            $userId = (int) $_POST["user_id"];
            $weight = (float) $_POST["weight"];
            $this->service->addWeight($userId, $weight);

            echo "Weight was added.";
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage() . "Code: " . $e->getCode();
        }
    }

    public function getWeightsByUser(): void
    {
        try {
            $userId = (int) $_POST["user_id"];
            $weights = $this->service->getWeightsById($userId);
            foreach ($weights as $weight) {
                echo $weight->getWeight() . "kg;" . $weight->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
            }
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage() . "Code : " . $e->getCode();
        }
    }
}
