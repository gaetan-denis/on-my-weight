<?php

namespace OnTheWeight\repositories;

use OnTheWeight\database\Database;
use OnTheWeight\entities\User;
use DateTime;
use DateTimeImmutable;
use PDO;
use RuntimeException;

class UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = new Database()->connect();
    }

    /**
     * Create a new user.
     *
     * @param string $username The username of the user.
     *
     * @param string $email The email of the user.
     *
     * @param string $passwordHash The password hashed of the user.
     *
     * @throws RuntimeException If the user is not add.
     */
    public function addUser(string $username, string $email, string $passwordHash): void
    {
        $sql = "INSERT INTO `users` (username, email, password_hash) VALUES (:username, :email, :passwordHash)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['username' => $username, 'email' => $email, 'passwordHash' => $passwordHash]);

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("No user added.");
        }
    }

    /**
     * Gets the user by email.
     *
     * @param string $email The email of the user.
     *
     * @return User The user.
     *
     *@throws RuntimeException If the user is not found.
     */
    public function getUserByEmail(string $email): User
    {
        $sql = 'SELECT * FROM users WHERE email = :email';
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new RuntimeException("User not found.");
        }
        return new User(
            $data['id'],
            new DateTimeImmutable($data['created_at']),
            new DateTime($data['updated_at']),
            $data['username'],
            $data['email'],
            $data['password_hash']
        );
    }
    /**
     * Gets the user by id.
     *
     * @param int $id The id of the user.
     *
     *@throws RuntimeException
     */
    public function getUserById(int $id): User
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            throw new RuntimeException("User not found.");
        }
        return new User(
            $data['id'],
            new DateTimeImmutable($data['created_at']),
            new DateTime($data['updated_at']),
            $data['username'],
            $data['email'],
            $data['password_hash'],
        );
    }

    /**
     * Gets all the users.
     *
     * @return array All the users.
     */
    public function getAllUsers(): array
    {
        $users = [];
        $sql = 'SELECT * FROM users';
        $query = $this->db->query($sql);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($data as $user) {
            $users[] = new User(
                $user['id'],
                new DateTimeImmutable($user['created_at']),
                new DateTime($user['updated_at']),
                $user['username'],
                $user['email'],
                $user['password_hash']
            );
        }
        return $users;
    }

    /**
     * Update the user.
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function updateUser(User $user): void
    {
        $sql = "UPDATE users SET username = :username, email = :email, password_hash = :password_hash WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            "password_hash" => $user->getPasswordHash(),
            'id' => $user->getId()
        ]);

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("No user was updated,, check if the ID exist.");
        }
    }

    /**
     * Delete the user.
     *
     * @return void
     *
     * @throws RuntimeException If no user was deleted.
     */
    public function deleteUser(int $id): void
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        if ($stmt->rowCount() === 0) {
            throw new RuntimeException("No user was deleted, check if the ID exist.");
        }
    }
}
