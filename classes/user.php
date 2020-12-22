<?php

class User{
    public $user_id;

    //Required
    public $name;
    public $email;
    public $is_admin;
    //
    

    public function createUser($name, $email){
        $this->name = $name;
        $this->email = $email;
        $this->is_admin = false;

        //TODO
    }

    public function setAdmin($is_admin){
        $this->is_admin = $is_admin;

        // TODO
    }
}

?>