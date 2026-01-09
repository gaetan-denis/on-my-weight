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
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            throw new RuntimeException("Unauthorized");
            return;
        }
        try {
            $userId = $_SESSION['user_id'];
            $weight = (float) $_POST["weight"];
            $this->service->addWeight($userId, $weight);

            echo "Weight was added.";
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage() . "Code: " . $e->getCode();
        }
    }

    public function getWeightsByUser(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            throw new RuntimeException("Unauthorized");
            return;
        }
        try {
            $userId = $_SESSION['user_id'];
            $weights = $this->service->getWeightsById($userId);
            foreach ($weights as $weight) {
                echo $weight->getWeight() . "kg;" . $weight->getCreatedAt()->format('Y-m-d H:i:s') . "<br>";
            }
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage() . "Code : " . $e->getCode();
        }
    }
}
