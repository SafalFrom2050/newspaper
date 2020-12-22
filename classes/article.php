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

    function createArticle($title, $author, $body, $category_id){
        $this->title = $title;
        $this->author = $author;
        $this->body = $body;
        $this->category_id = $category_id;
    }

    function setPublished($is_published){
        $this->is_published = $is_published;
    }

    function setImage($image_url){
        $this->image_url = $image_url;
    }

}

?>