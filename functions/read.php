<?php

function getListOfCategories(){
    $pdo = createDatabaseConnection();

    $stmp = $pdo->prepare('SELECT * FROM `categories`');

    $stmp->execute();

    $categories = array();
    foreach($stmp as $row){
        $category = Category::fromDB($row);
        $categories[] = $category;
    }

    return $categories;
}

function getListOfArticles(){
    $pdo = createDatabaseConnection();

    $stmp = $pdo->prepare('SELECT * FROM `articles`');

    $stmp->execute();

    $articles = array();
    foreach($stmp as $row){
        $article = Article::fromDB($row);
        $articles[] = $article;
    }
    return $articles;
}


?>