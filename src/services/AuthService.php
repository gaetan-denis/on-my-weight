<?php

namespace OnTheWeight\services;

use DateTime;
use DateTimeImmutable;
use OnTheWeight\repositories\UserRepository;
use OnTheWeight\entities\User;
use RuntimeException;

class AuthService
{
    public function __construct(private UserRepository $repo)
    {
    }
    public function login(string $email, string $password): void
    {
        $user = $this->repo->getUserByEmail($email);
        if (!$user->verifyPassword($password)) {
            throw new RunTimeException("Invalid credentials.");
        }
        session_start();
        $_SESSION['user_id'] = $user->getId();
    }

    public function logout(): void
    {
        session_start();
        session_abort();
        session_destroy();
    }

    public function register(string $username, string $email, string $password)
    {
        $user = new User(
            0,
            new DateTimeImmutable(),
            new DateTime(),
            $username,
            $email,
            $password
        );
        $user->setPassword($password);
        $this->repo->addUser($user->getUsername(), $user->getEmail(), $user->getPasswordHash());
    }
}
