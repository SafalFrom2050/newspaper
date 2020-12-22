<?php

function getListOfCategories(){
    $pdo = createDatabaseConnection();

    $stmp = $pdo->prepare('SELECT * FROM `categories`');

    $stmp->execute();

    $categories = array();
    foreach($stmp as $row){
        $category = new Category($row['category_id'], $row['name']);
        $categories[] = $category;
    }

    return $categories;
}



?>