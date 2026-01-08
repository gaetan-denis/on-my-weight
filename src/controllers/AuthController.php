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

            $this->service->login($email, $password);
            echo "Login successful";
        } catch (RuntimeException $e) {
            echo "Error : " . $e->getMessage() . "; Code: " . $e->getCode();
        }
    }

    public function logout(): void
    {
        $this->service->logout();
        echo  "Logged out";
    }

    public function register(): void
    {
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
