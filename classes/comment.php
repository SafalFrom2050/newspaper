<?php

class Comment extends Database{
    public $comment_id;

    //Required
    public $user_id;
    public $user_name;
    public $article_id;
    public $comment_text;
    //

    public $post_datetime;
    public $is_approved;


    public function __construct() {
        
    }

    public static function fromDB($row){
        $instance = new self();
                                                 
        $instance->comment_id = $row['comment_id'];
        $instance->comment_text = $row['comment_text'];
        $instance->post_datetime = $row['post_datetime'];
        $instance->is_approved = $row['is_approved'];
        $instance->article_id = $row['article_id'];
        $instance->user_id = $row['user_id'];
        $instance->user_name = $row['name'];

        return $instance;
    }

    public static function createComment($comment_text, $article_id){
        $instance = new self();

        $instance->comment_text = $comment_text;
        $instance->article_id = $article_id;

        $user = new User();
        $instance->user_id = $user->user_id;
        
        //Approve all admins commments
        if($user->isAdmin()){
            $instance->is_approved = true;
        }else{
            $instance->is_approved = false;
        }

        return $instance;
        //TODO
    }

    public function postComment($comment = null){
        if(is_null($comment)){
            $comment = $this;
        }

        $sql = 'INSERT INTO `comments`(`comment_text`, `user_id`, `is_approved`, `article_id`)
        VALUES (:comment_text, :user_id, :is_approved, :article_id)';

        $criteria = [
            'comment_text' => $comment->comment_text,
            'user_id' => $comment->user_id,
            'is_approved' => $comment->is_approved,
            'article_id' => $comment->article_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);
        
        return $stmp;
    }

    public function getCommentsForId($article_id = null){
        
        if(!is_null($article_id)){
            $comment = $this;
            $comment->article_id = $article_id;
        }

        $sql = 'SELECT `comments`.*, `articles`.`article_id`, `users`.`name` FROM `comments` 
                JOIN `articles` ON `comments`.`article_id`=`articles`.`article_id` AND `comments`.`article_id` = :article_id 
                JOIN `users` ON `comments`.`user_id`=`users`.`user_id`;';

        $criteria = [
            'article_id' => $comment->article_id
        ];
        
        $stmp = $this->executeWithCriteria($sql, $criteria);
        
        $comments = array();

        foreach($stmp as $row){
            $comment = Comment::fromDB($row);
            $comments[] = $comment;
        }
        return $comments;
        
    }

    public function setApproved($is_approved){
        $this->is_approved = $is_approved;
        // TODO
    }
}

?>