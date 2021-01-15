<?php

class Category extends Database
{
    public $category_id;

    //Required
    public $name;
    //

    public function __construct()
    {
    }

    public static function withID($category_id)
    {
        $instance = new self();
        $category = $instance->getCategoryFromId($category_id);

        $instance->category_id = $category->category_id;
        $instance->name = $category->name;
        return $instance;
    }
    public static function withName($name)
    {
        $instance = new self();
        $instance->name = $name;
        return $instance;
    }
    public static function fromDB($row)
    {
        $instance = new self();
        $instance->name = $row['name'];
        $instance->category_id = $row['category_id'];
        return $instance;
    }

    public function getName()
    {
        return $this->name;
    }

    public function createCategory($name)
    {
        $this->name = $name;

        $sql = 'INSERT INTO `categories` (`name`) VALUES (:name)';
        $criteria = ['name' => $name];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }

    public function rename($new_name)
    {
        $this->name = $new_name;
        $sql = 'UPDATE `categories` SET `name`=:name
            WHERE `category_id`=:category_id';

        $criteria = [
            'category_id' => $this->category_id,
            'name' => $new_name
        ];

        $this->executeWithCriteria($sql, $criteria);
    }

    public function getId()
    {

        $sql = 'SELECT * FROM `categories` WHERE name=:name';

        $criteria = ['name' => $this->name];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $category_id = $stmp->fetch(PDO::FETCH_ASSOC);

        return $category_id['category_id'];
    }

    public function getListOfCategories()
    {

        $sql = 'SELECT * FROM `categories`';

        $stmp = $this->executeSql($sql);

        $categories = array();
        foreach ($stmp as $row) {
            $category = Category::fromDB($row);
            $categories[] = $category;
        }

        return $categories;
    }

    public function getCategoryFromId($category_id)
    {

        $sql = 'SELECT * FROM `categories` WHERE category_id=:category_id';

        $criteria = [
            'category_id' => $category_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $row = $stmp->fetch();
        $category = Category::fromDB($row);

        return $category;
    }

    public function deleteCategory($category_id = null)
    {

        if (is_null($category_id)) {
            $category_id = $this->category_id;
        }

        $sql = 'DELETE FROM `categories` WHERE category_id=:category_id';

        $criteria = [
            'category_id' => $category_id
        ];

        $this->executeWithCriteria($sql, $criteria);
    }
}
