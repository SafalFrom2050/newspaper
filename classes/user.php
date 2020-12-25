<?php

class User extends Database{
    public $user_id;

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