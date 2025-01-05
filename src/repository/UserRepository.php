<?php

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $statement = $this->database->connect()->prepare(
            'SELECT * FROM public.users WHERE email = :email');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if(!$user)
        {
            return null;
        }

        return new User(
            $user['email'],
            $user['password'],
            $user['nickname']
        );
    }

    public function createUser(User $user): void
    {
        $statement = $this->database->connect()->prepare('
            INSERT INTO public.users (nickname, email, password)
            VALUES (:nickname, :email, :password)
        ');

        $email = $user->getEmail();
        $password = $user->getPassword();
        $nickname = $user->getNickname();

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);

        $statement->execute();
    }
}