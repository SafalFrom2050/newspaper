<?php

class User extends Database
{
    public $user_id;

    public $username;

    //Required
    public $name;
    public $email;
    public $is_admin;
    //

    public function __construct($user_id = null)
    {
        if (is_null($user_id) && isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
        } else {
            $this->user_id = $user_id;
        }
    }

    public static function current($user_id = null)
    {
        if (is_null($user_id) && isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        } else {
            $user_id = $user_id;
        }

        return User::withID($user_id);
    }
    public static function withID($user_id)
    {

        $instance = new self();

        $user = $instance->getUserFromId($user_id);

        $instance->user_id = $user['user_id'];
        $instance->name = $user['name'];
        $instance->email = $user['email'];
        $instance->username = $user['username'];
        $instance->is_admin = $user['is_admin'];

        return $instance;
    }
    public static function fromDB($row)
    {
        $instance = new self();
        $instance->user_id = $row['user_id'];
        $instance->name = $row['name'];
        $instance->email = $row['email'];
        $instance->username = $row['username'];
        $instance->is_admin = $row['is_admin'];

        return $instance;
    }

    public function getAllUsersList()
    {
        $sql = 'SELECT * FROM `users`';

        $stmp = $this->executeSql($sql);

        $users = array();
        foreach ($stmp as $row) {
            $user = User::fromDB($row);
            $users[] = $user;
        }

        return $users;
    }

    public function getAllAdminsList()
    {
        $sql = 'SELECT * FROM `users` WHERE `is_admin` = 1';

        $stmp = $this->executeSql($sql);

        $users = array();
        foreach ($stmp as $row) {
            $user = User::fromDB($row);
            $users[] = $user;
        }

        return $users;
    }

    public function delete($user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = $this->user_id;
        }

        $sql = 'DELETE FROM `users` WHERE user_id=:user_id';

        $criteria = [
            'user_id' => $user_id
        ];

        $this->executeWithCriteria($sql, $criteria);
    }

    public function getUserFromId($user_id)
    {

        $sql = 'SELECT * FROM users WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $user_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        return $user;
    }

    public function getUserFromUsername($username)
    {

        $sql = 'SELECT * FROM users WHERE username = :username';

        $criteria = [
            'username' => $username
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        if (!$user) {
            return false;
        }

        return User::fromDB($user);
    }

    public function getUserFromEmail($email)
    {

        $sql = 'SELECT * FROM users WHERE email = :email';

        $criteria = [
            'email' => $email
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        if (!$user) {
            return false;
        }

        return User::fromDB($user);
    }

    public function createUser($user_id, $email, $is_admin = false)
    {
        $this->user_id = $user_id;
        $this->email = $email;
        $this->is_admin = $is_admin;

        return $this;
        //TODO
    }

    public function setAdmin($is_admin = 1, $user_id = null)
    {
        if (is_null($user_id)) {
            $user_id = $this->user_id;
        }
        $this->is_admin = $is_admin;

        $sql = 'UPDATE `users` SET `is_admin`=:is_admin 
        WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $user_id,
            'is_admin' => $is_admin
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }


    public function signUp($username, $name, $email)
    {
        $password = rand(100000, 500000);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `users` (`username`, `password`, `name`, `email`) 
                    VALUES (:username, :password, :name, :email)';

        $criteria = [
            'username' => $username,
            'password' => $password_hash,
            'name' => $name,
            'email' => $email
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        return $password;
    }

    public function createAdmin($username, $password, $email, $name)
    {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'INSERT INTO `users` (`username`, `password`, `name`, `email`, `is_admin`) 
                    VALUES (:username, :password, :name, :email, 1)';

        $criteria = [
            'username' => $username,
            'password' => $password_hash,
            'name' => $name,
            'email' => $email
        ];

        $this->executeWithCriteria($sql, $criteria);
    }



    public function updateUserPassword($password)
    {

        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = 'UPDATE `users` SET `password`=:password 
                WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $this->user_id,
            'password' => $password_hash
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }

    public function updateUserDisplayName($name)
    {

        $sql = 'UPDATE `users` SET `name`=:name 
                WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $this->user_id,
            'name' => $name
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }

    public function updateUserUsername($username)
    {

        $sql = 'UPDATE `users` SET `username`=:username 
                WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $this->user_id,
            'username' => $username
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }

    public function updateUserEmail($email)
    {

        $sql = 'UPDATE `users` SET `email`=:email 
                WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $this->user_id,
            'email' => $email
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }


    public function verifyUserPassword($password)
    {

        $sql = 'SELECT * FROM users WHERE user_id = :user_id';
        $criteria = [
            'user_id' => $this->user_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        if (password_verify($password, $user['password'])) {
            return true;
        }

        return false;
    }

    public function verifyUserCredentials($username, $password)
    {

        $sql = 'SELECT * FROM users WHERE username = :username';
        $criteria = [
            'username' => $_POST['username']
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        if (password_verify($password, $user['password'])) {
            return $this->createUser($user['user_id'], $user['email'], false);
        } else {
            return null;
        }
    }

    public function doesUsernameExist($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username';
        $criteria = [
            'username' => $username
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();
        if (is_null($user['username'])) {
            return false;
        } else {
            return true;
        }
    }

    public static function isLoggedIn()
    {
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        $user_id = $this->user_id;

        $sql = 'SELECT * FROM users WHERE user_id = :user_id';
        $criteria = [
            'user_id' => $user_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $user = $stmp->fetch();

        return $user['is_admin'];
    }
}
