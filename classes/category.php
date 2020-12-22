<?php

class Category{
    public $category_id;

    //Required
    public $name;
    //

    public function __construct($category_id, $name) {
        $this->category_id = $category_id;
        $this->name = $name;
    }

    public function getName(){
        return $this->name;
    }

    public function createCategory($name){
        $this->name = $name;

        //TODO
    }

    public function rename($category_id, $name){
        $this->name = $name;
        
        // TODO
    }
}

?>