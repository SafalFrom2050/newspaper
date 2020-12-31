<?php

class User extends Database{
    public $user_id;

    public $username;

    //Required
    public $name;
    public $email;
    public $is_admin;
    //
    
    public function __construct($user_id = null) {
        if(is_null($user_id)){
            $this->user_id = $_SESSION['user_id'];
        }else{
            $this->user_id = $user_id;
        }
    }

    public static function withID($user_id){

        $instance = new self();
        
        $user = $instance->getUserFromId($user_id);

        $instance->user_id = $user['user_id'];
        $instance->name = $user['name'];
        $instance->email = $user['email'];
        $instance->username = $user['username'];
        $instance->is_admin = $user['is_admin'];

        return $instance;
    }
    public static function fromDB($row){
        $instance = new self();
        $instance->user_id = $row['user_id'];
        $instance->name = $row['name'];
        $instance->email = $row['email'];
        $instance->username = $row['username'];
        $instance->is_admin = $row['is_admin'];

        return $instance;
    }

    public function getUserFromId($user_id){

        $sql = 'SELECT * FROM users WHERE user_id = :user_id';

        $criteria = [
            'user_id' => $user_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        return $user;
    }

    public function createUser($user_id, $email, $is_admin=false){
        $this->user_id = $user_id;
        $this->email = $email;
        $this->is_admin = $is_admin;

        return $this;
        //TODO
    }

    public function setAdmin($is_admin){
        $this->is_admin = $is_admin;

        // TODO
    }

    public function verifyUserCredentials($username, $password){

        $sql = 'SELECT * FROM users WHERE username = :username';
        $criteria = [
            'username' => $_POST['username']
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        $user = $stmp->fetch();

        if(password_verify($password, $user['password'])){
            return $this->createUser($user['user_id'], $user['email'], false);
        }else{
            return null;
        }
    }

    public function isLoggedIn(){
        if(!$_SESSION['logged_in']){
            return false;
        }
        return true;
    }

    public function isAdmin(){
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

?>