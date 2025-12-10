<?php

namespace OnTheWeight\entities;

use DateTime;
use DateTimeImmutable;
use InvalidArgumentException;
use LengthException;

class User extends BaseEntity
{
    private string $username;
    private string $email;
    private string $passwordHash;

    public function __construct(
        int $id,
        DateTimeImmutable $createdAt,
        DateTime $updatedAt,
        string $username,
        string $email,
        string $passwordHash
    ) {
        parent::__construct($id, $createdAt, $updatedAt);
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPasswordHash($passwordHash);
    }


    // Getters

    /**
     * Gets the username of the user.
     *
     * @return string The username of the user.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get the email of the user.
     *
     * @return string The email of the user.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    // Setters

    /**
     * Sets the username of the user.
     *
     * @param string $username The username of the user.
     *
     * @return void
     */
    public function setUsername(string $username): void
    {
        $length = strlen($username);

        if ($length === 0) {
            throw new InvalidArgumentException("Username cannot be empty.");
        }
        if ($length > 0 && $length < 3) {
            throw new LengthException("Username must have at least 3 characters.");
        }
        if ($length > 50) {
            throw new LengthException("Username cannot exceed 50 characters.");
        }
        $this->username = $username;
    }

    /**
     * Sets the email of the user.
     *
     * @param string $email The email of the user.
     *
     * @return void
     */
    public function setEmail(string $email): void
    {
        $email = trim($email);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email must be valid.");
        }
        $this->email = strtolower($email);
    }

    /**
     *  Sets the password hashed of the user.
     *
     * @param string $password The password of the user.
     *
     * @return void
     *
     * @throws InvalidArgumentException If the password is empty.
     * @throws InvalidArgumentException If the password does not have at least 1 lowercase character.
     * @throws InvalidArgumentException If the password does not have at least 1 uppercase character.
     * @throws InvalidArgumentException If the password does not have at least 1 number.
     * @throws InvalidArgumentException If the password does not have at least 1 special character.
     * @throws LengthException If the password is shorter than 8 characters or longer than 70 characters.
     */

    public function setPassword(string $password): void
    {
        $password = trim($password);
        if (empty($password)) {
            throw new InvalidArgumentException("Password cannot be empty.");
        }

        if (!preg_match('/[a-z]/', $password)) {
            throw new InvalidArgumentException("Password must have at least 1 lowercase character.");
        }
        if (!preg_match('/[A-Z]/', $password)) {
            throw new InvalidArgumentException("Password must have at least 1 uppercase character.");
        }
        if (!preg_match('/[0-9]/', $password)) {
            throw new InvalidArgumentException("Password must have a number.");
        }
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            throw new InvalidArgumentException("Password must have a special character.");
        }
        if (mb_strlen($password) < 8) {
            throw new LengthException("Password must have at least 8 characters.");
        }
        if (mb_strlen($password) > 70) {
            throw new LengthException("Password cannot exceed 70 characters.");
        }
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }


    public function setPasswordHash(string $passwordHash): void
    {
        $this->passwordHash = $passwordHash;
    }

    /**
     * Verify if the plain password matches the hashed password.
     *
     * @param string $plainPassword The plain password of the user.
     *
     * @return void
     */
    public function verifyPassword(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->passwordHash);
    }
}
