<?php

class Article extends Database{
    public $article_id;
    public $title;
    public $post_datetime;

    //user_id
    public $author;

    public $body;
    public $is_published;
    public $category_id;
    public $image_url;

    public function __construct() {
        
    }

    public static function fromParameters($title, $user_id, $body, $image_url, $category_id, $is_published){
        $instance = new self();

        $instance->title = $title;
        
        // NOTE: user_id is the author
        $instance->author = $user_id;
        
        $instance->body = $body;
        $instance->image_url = $image_url;
        $instance->category_id = $category_id;
        $instance->is_published = $is_published;

        return $instance;
    }

    public static function fromDB($row){
        $instance = new self();
                                                 
        $instance->article_id = $row['article_id'];
        $instance->title = $row['title'];
        $instance->post_datetime = $row['post_datetime'];
        $instance->author = $row['author'];
        $instance->body = $row['body'];
        $instance->image_url = $row['image_url'];
        $instance->category_id = $row['category_id'];
        $instance->is_published = $row['is_published'];

        return $instance;
    }

    public function setPublished($is_published){
        $this->is_published = $is_published;
    }

    public function setImage($image_url){
        $this->image_url = $image_url;
    }

    const SORT_BY_LATEST = 1, SORT_DEFAULT = 0;
    public function getListOfArticles($sort_by = self::SORT_DEFAULT){
        if($sort_by==self::SORT_BY_LATEST){
            $sql = 'SELECT * FROM `articles` ORDER BY post_datetime DESC';    
        }else if($sort_by==self::SORT_DEFAULT){
            $sql = 'SELECT * FROM `articles`';    
        }else{
            $sql = 'SELECT * FROM `articles`';
        }
        
        $stmp = $this->executeSql($sql);
    
        $articles = array();
        foreach($stmp as $row){
            $article = Article::fromDB($row);
            $articles[] = $article;
        }
        return $articles;
    }

    public function getArticleFromId($article_id){
        $sql = 'SELECT * FROM `articles` WHERE article_id=:article_id';

        $criteria = [
            'article_id' => $article_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    
        $row = $stmp->fetch();
        $article = Article::fromDB($row);

        return $article;
    }

    public function postArticle($article=null){

        if(is_null($article)){
            $article = $this;
        }

        $sql = 'INSERT INTO `articles`(`title`, `user_id`, `body`, `image_url`, `category_id`, `is_published`)
        VALUES (:title, :user_id, :body, :image_url, :category_id, :is_published)';

        $criteria = [
            'title' => $article->title,
            'user_id' => $article->author,
            'body' => $article->body,
            'image_url' => $article->image_url,
            'category_id' => $article->category_id,
            'is_published' => $article->is_published
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        
        return $stmp;
    }

    public function editPost($article=null){

        if(is_null($article)){
            $article = $this;
        }

        // Validation
        if(is_null($article->article_id)){
            echo 'Cannot Update!!! Looks like you article_ID was not included...';
            return false;
        }
    
        $sql = 'UPDATE `articles` SET `title`=:title, `user_id`=:user_id, 
                `body`=:body, `image_url`=:image_url, `category_id`=:category_id, `is_published`=:is_published
                WHERE `article_id`=:article_id';

        $criteria = [
            'article_id' => $article->article_id,
            'title' => $article->title,
            'user_id' => $article->author,
            'body' => $article->body,
            'image_url' => $article->image_url,
            'category_id' => $article->category_id,
            'is_published' => $article->is_published
        ];
        
        $stmp = $this->executeWithCriteria($sql, $criteria);
        
        return true;
    }
}

?>