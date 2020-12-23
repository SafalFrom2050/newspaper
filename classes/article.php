<?php

class Article{
    public $article_id;
    public $title;
    public $date;

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
        $instance->date = $row['date'];
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
}

?>