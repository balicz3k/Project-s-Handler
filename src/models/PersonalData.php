<?php

namespace models;
class PersonalData
{
    private $firstName;
    private $lastName;
    private $birthDate;
    private $gender;
    private $phoneNumber;

    public function __construct(
        string $firstName,
        string $lastName,
        \DateTime $birthDate,
        string $gender,
        string $phoneNumber
    )
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->gender = $gender;
        $this->phoneNumber = $phoneNumber;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }
}