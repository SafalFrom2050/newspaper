<?php

class Category{
    public $category_id;

    //Required
    public $name;
    //

    public function __construct() {
        
    }

    public static function withID($category_id){
        $instance = new self();
        $instance->category_id = $category_id;
        return $instance;
    }
    public static function withName($name){
        $instance = new self();
        $instance->name = $name;
        return $instance;
    }
    public static function fromDB($row){
        $instance = new self();
        $instance->name = $row['name'];
        $instance->category_id = $row['category_id'];
        return $instance;
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

    function getId(){
        $pdo = createDatabaseConnection();
    
        $sql = 'SELECT * FROM `categories` WHERE name=:name';

        $stmp = $pdo->prepare($sql);
    
        $criteria = ['name' => $this->name];

        $stmp->execute($criteria);
    
        $category_id = $stmp->fetch(PDO::FETCH_ASSOC);

        return $category_id['category_id'];
    }
}

?>