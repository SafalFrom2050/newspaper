<?php

function postArticle($article){
    $pdo = createDatabaseConnection();

    $stmp = $pdo->prepare('INSERT INTO `articles`(`title`, `user_id`, `body`, `image_url`, `category_id`, `is_published`)
                            VALUES (:title, :user_id, :body, :image_url, :category_id, :is_published)');

    $criteria = [
        'title' => $article->title,
        'user_id' => $article->author,
        'body' => $article->body,
        'image_url' => $article->image_url,
        'category_id' => $article->category_id,
        'is_published' => $article->is_published
    ];
    $stmp->execute($criteria);
    
    return true;
}

?>