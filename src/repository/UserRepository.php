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
            $user['user_id'],
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

    public function updateEmail($userId, $email)
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            throw new Exception('User is not logged in.');
        }

        $statement = $this->database->connect()->prepare('
            UPDATE public.users SET email = :email WHERE user_id = :user_id
        ');

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();

        $_SESSION['user_email'] = $email;
    }

    public function updateNickname($userId, $nickname)
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            throw new Exception('User is not logged in.');
        }

        $statement = $this->database->connect()->prepare('
            UPDATE public.users SET nickname = :nickname WHERE user_id = :user_id
        ');

        $statement->bindParam(':nickname', $nickname, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();

        $_SESSION['user_nickname'] = $nickname;
    }

    public function updatePassword($userId, $password)
    {
        session_start();

        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            throw new Exception('User is not logged in.');
        }

        $statement = $this->database->connect()->prepare('
            UPDATE public.users SET password = :password WHERE user_id = :user_id
        ');

        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':user_id', $userId, PDO::PARAM_INT);

        $statement->execute();
    }
}