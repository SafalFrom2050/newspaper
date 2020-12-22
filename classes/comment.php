<?php

class Comment{
    public $comment_id;

    //Required
    public $user_id;
    public $article_id;
    public $text;
    //

    public $date;
    public $is_approved;

    public function createComment($text, $article_id, $user_id){
        $this->text = $text;
        $this->article_id = $article_id;
        $this->user_id = $user_id;

        $this->date = new Date();

        //TODO
    }

    public function setApproved($is_approved){
        $this->is_approved = $is_approved;
        // TODO
    }
}

?>