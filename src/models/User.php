<?php

class User
{
    private $password;
    private $nickname;
    private $email;

    public function __construct(
        string $email,
        string $password,
        string $nickname
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->nickname = $nickname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getNickname()
    {
        return $this->nickname;
    }
}