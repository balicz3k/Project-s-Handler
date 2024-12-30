<?php

namespace models;

class User
{
    private $password;
    private $name;
    private $surname;
    private $email;

    public function __construct(
        string $email,
        string $password,
        string $name,
        string $surname
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }
}