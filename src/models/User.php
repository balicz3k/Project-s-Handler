<?php

class User
{
    private $password;
    private $nickname;
    private $email;
    private $id;

    public function __construct(
        $id,
        string $email,
        string $password,
        string $nickname
    ) {
        $this->id = $id;
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

    public function getId()
    {
        return $this->id;
    }
}