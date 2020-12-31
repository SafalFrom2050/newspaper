<?php

class Article extends Database{
    public $article_id;
    public $title;
    public $post_datetime;

    //user_id
    public $user_id;
    public $author;

    public $body;
    public $is_published;
    public $category_id;
    public $image_url;
    public $views;

    public function __construct() {
        
    }

    public static function fromParameters($title, $user_id, $body, $image_url, $category_id, $is_published){
        $instance = new self();

        $instance->title = $title;
        
        $instance->user_id = $user_id;

        // NOTE: current user_name is the author
        $user = User::withID($user_id);
        $user_name = $user->name;

        $instance->author = $user_name;
        
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
        $instance->user_id = $row['user_id'];
        $instance->author = $row['author'];
        $instance->body = $row['body'];
        $instance->image_url = $row['image_url'];
        $instance->category_id = $row['category_id'];
        $instance->is_published = $row['is_published'];
        $instance->views = $row['views'];

        return $instance;
    }

    public function setPublished($is_published){
        $this->is_published = $is_published;
    }

    public function setImage($image_url){
        $this->image_url = $image_url;
    }

    public function addViewCount(){
        $sql = 'UPDATE `articles` SET `views` = `views` + 1 WHERE `article_id`=:article_id';

        $criteria = ['article_id' => $this->article_id];

        $stmp = $this->executeWithCriteria($sql, $criteria);
    }

    const SORT_DEFAULT = 0, SORT_BY_LATEST = 1, SORT_BY_OLDEST = 2, SORT_BY_LONGEST = 3, SORT_BY_SHORTEST = 4;
    public function getListOfArticles($sort_by = self::SORT_DEFAULT, $is_published = -1){
        $sql = 'SELECT * FROM `articles`';

        if($is_published !== -1){
            $sql .= ' WHERE is_published = '.$is_published;
        }
        
        if($sort_by==self::SORT_BY_LATEST){
            $sql .= ' ORDER BY post_datetime DESC';    
        }else if($sort_by==self::SORT_BY_OLDEST){
            $sql .= ' ORDER BY post_datetime ASC';
        }else if($sort_by==self::SORT_BY_LONGEST){
            $sql .= ' ORDER BY LENGTH(body) DESC';
        }else if($sort_by==self::SORT_BY_SHORTEST){
            $sql .= ' ORDER BY LENGTH(body) ASC';
        }else{
            $sql .= ' ORDER BY views DESC';
        }
        
        $stmp = $this->executeSql($sql);
    
        $articles = array();
        foreach($stmp as $row){
            $article = Article::fromDB($row);
            $articles[] = $article;
        }
        return $articles;
    }

    public function getListFromCategory($category_id, $sort_by = self::SORT_DEFAULT, $is_published = -1){
        $sql = 'SELECT * FROM `articles` WHERE `category_id`=:category_id';

        if($is_published !== -1){
            $sql .= ' AND is_published = '.$is_published;
        }

        if($sort_by==self::SORT_BY_LATEST){
            $sql .= ' ORDER BY post_datetime DESC';    
        }else if($sort_by==self::SORT_BY_OLDEST){
            $sql .= ' ORDER BY post_datetime ASC';
        }else if($sort_by==self::SORT_BY_LONGEST){
            $sql .= ' ORDER BY LENGTH(body) DESC';
        }else if($sort_by==self::SORT_BY_SHORTEST){
            $sql .= ' ORDER BY LENGTH(body) ASC';
        }

        $criteria = ['category_id' => $category_id];

        $stmp = $this->executeWithCriteria($sql, $criteria);

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

        $sql = 'INSERT INTO `articles`(`title`, `author`, `user_id`, `body`, `image_url`, `category_id`, `is_published`)
        VALUES (:title, :author, :user_id, :body, :image_url, :category_id, :is_published)';

        $criteria = [
            'title' => $article->title,
            'author' => $article->author,
            'user_id' => $article->user_id,
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
    
        $sql = 'UPDATE `articles` SET `title`=:title, `author`=:author, `user_id`=:user_id, 
                `body`=:body, `image_url`=:image_url, `category_id`=:category_id, `is_published`=:is_published
                WHERE `article_id`=:article_id';

        $criteria = [
            'article_id' => $article->article_id,
            'title' => $article->title,
            'author' => $article->author,
            'user_id' => $article->user_id,
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