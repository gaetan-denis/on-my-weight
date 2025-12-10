<?php

namespace OnTheWeight\entities;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;

class Weight extends BaseEntity
{
    private float $weight;

    public function __construct(
        int $id,
        DateTimeImmutable $createdAt,
        DateTime $updatedAt,
        float $weight
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->weight = $weight;
    }

    // Getters

    /**
     * Get the weight.
     *
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    //Setters

    /**
     * Sets the weight.
     *
     * @param float $weigth The weight.
     *
     * @return void
     *
     * @throws InvalidArgumentException If the weight is empty.
     * @throws InvalidArgumentException If the weight is negative.
     */
    public function setWeight($weight): void
    {
        if (!is_numeric($weight)) {
            throw new InvalidArgumentException("Weight must be a number.");
        }
        if ($weight < 0) {
            throw new InvalidArgumentException("Weight cannot be negative.");
        }
        $this->weight = $weight;
    }
}
