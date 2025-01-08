<?php

class User
{
    private $password;
    private $nickname;
    private $email;
    private $id;
    private $role;

    public function __construct(
        $id,
        string $email,
        string $password,
        string $nickname,
        $role
    ) {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nickname = $nickname;
        $this->role = $role;
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

    public function getRole()
    {
        return $this->role;
    }
}