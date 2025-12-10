<?php

namespace OnTheWeight\entities;

use DateTime;
use DateTimeImmutable;

class BaseEntity
{
    private readonly int $id;
    private DateTimeImmutable $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id,
        ?DateTimeImmutable $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt ?? new DateTimeImmutable();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    /**
     * Updates the timestamp of the creation's date.
     *
     * @return void
     */
    public function touch(): void
    {
        $this->updatedAt = new DateTime();
    }

    // Getters

    /**
    * Gets the id of the entity.
    *
    * @return int The id of the entity.
    *
    */
    public function getId(): int
    {
        return $this->id;
    }

    /**
    * Gets the timestamp of the creation's date of the entity.
    *
    * @return DateTimeImmutable The creation's date of the entity.
    */
    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Gets the timestamp of the update's date of the entity.
     *
     * @return DateTime The update's date of the entity.
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }
}
