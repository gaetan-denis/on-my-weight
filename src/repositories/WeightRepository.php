<?php

namespace OnTheWeight\repositories;

use OnTheWeight\database\Database;
use OnTheWeight\entities\Weight;
use DateTime;
use DateTimeImmutable;
use PDO;
use RuntimeException;

class WeightRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new Database()->connect();
    }

    // Create

    /**
     * Create a new weight
     *
     * @param float $weight
     *
     * @return void
     *
     * @throws RuntimeException If no weight is add.
     */
    public function createWeight(int $userId, float $weight): void
    {
        $sql = "INSERT INTO `weights` (user_id, weight) VALUES (:user_id, :weight)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'weight' => $weight
        ]);

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("No weight was added.");
        }
    }

    // Read

    /**
     * Gets weight by id.
     *
     * @param int $id The id of the weight.
     *
     * @return Weight The weight.
     */
    public function getWeightbyId(int $id): Weight
    {
        $sql = "SELECT * FROM `weights` where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id ]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Weight(
            $data['id'],
            new DateTimeImmutable($data['created_at']),
            new DateTime($data['updated_at']),
            $data['weight']
        );
    }

    // Update

    /**
     * Update a weight.
     *
     * @param int $id The weight
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function updateWeight(int $id, float $weight): void
    {
        $sql = "UPDATE `weights` SET weight = :weight WHERE id= :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'weight' => $weight,
            'id' => $id
        ]);
        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("No weight was updated, check if the ID exist.");
        }
    }

    /**
     * Gets all the weights
     *
     * @return Weight[] Tableau d'objets Weigth
     */
    public function getAllWeights(): array
    {
        $sql = "SELECT * FROM `weights`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $weights = [];

        foreach ($data as $weight) {
            $weights[] = new Weight(
                $weight['id'],
                new DateTimeImmutable($weight['created_at']),
                new DateTime($weight['updated_at']),
                (float) $weight['weight']
            );
        }
        return $weights;
    }

    // Delete

    /**
    *  Delete a weight.
    *
    * @param int $id The id of the weight
    *
    * @return void
    *
    *@throws RuntimeException
    */
    public function deleteWeight(int $id): void
    {
        $sql = "DELETE FROM `weights` WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("No weight was deleted, check if the ID exist.");
        }
    }

    /**
     * Get all weights fot a given user.
     * @param int $id The id of the user.
     * @return Weights[]
     * @throws RunTimeException If no weight are found.
     */

    public function getAllWeightsByUser(int $userId): array
    {
        $sql = "SELECT * FROM `weights` WHERE user_id = :userId ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(["userId" => $userId]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$data) {
            return [];
        }
        $weights = [];
        foreach ($data as $row) {
            $weights[] = new Weight(
                $row['id'],
                new DateTimeImmutable($row["created_at"]),
                new DateTime($row["updated_at"]),
                (float) $row["weight"]
            );
        }
        return $weights;
    }
}
