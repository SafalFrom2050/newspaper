<?php

class Category{
    public $category_id;

    //Required
    public $name;
    //
    

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