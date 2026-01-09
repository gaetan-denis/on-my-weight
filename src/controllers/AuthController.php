<?php

namespace OnTheWeight\controllers;

use OnTheWeight\services\AuthService;
use RuntimeException;

class AuthController
{
    public function __construct(private AuthService $service)
    {
    }

    public function login(): void
    {
        try {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                throw new RuntimeException("Email and password are required.");
            }

            $this->service->login($email, $password);
            echo "Login successful";
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function logout(): void
    {
        $this->service->logout();
        echo  "Logged out";
    }

    public function register(): void
    {
        if ($_POST['username'] === '' || $_POST['email'] === ' ' || $_POST['password']) {
            throw new RuntimeException("Username, email and password are required.");
        }
        try {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $this->service->register($username, $email, $password);
            echo "User registered";
        } catch (RuntimeException $e) {
            echo "Error: " . $e->getMessage() . ";Code:" . $e->getCode();
        }
    }
}
