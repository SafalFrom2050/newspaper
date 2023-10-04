<?php

class CommentReply extends Comment
{

    // function to add new reply type comment in database
    public function postReply($comment_id, $comment = null)
    {
        // use self as $commment if parameter is null
        if (is_null($comment)) {
            $comment = $this;
        }


        // sql insert statement
        $sql = 'INSERT INTO `comments`(`comment_text`, `user_id`, `is_approved`, `article_id`, `reply_to`)
        VALUES (:comment_text, :user_id, :is_approved, :article_id, :reply_to)';

        $criteria = [
            'comment_text' => $comment->comment_text,
            'user_id' => $comment->user_id,
            'is_approved' => $comment->is_approved,             // Admin comments are automatically set to approve immediately
            'article_id' => $comment->article_id,
            'reply_to' => $comment_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        return $stmp;
    }

    // get list of replies for given comment id
    public function getReplies($comment_id)
    {

        $sql = 'SELECT `comments`.*, `articles`.`article_id`, `users`.`name` FROM `comments` 
                JOIN `articles` ON `comments`.`article_id`=`articles`.`article_id` 
                AND `comments`.`reply_to` = :reply_to
                AND `comments`.`is_approved`=1
                JOIN `users` ON `comments`.`user_id`=`users`.`user_id`;';

        $criteria = [
            'reply_to' => $comment_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $comments = array();

        foreach ($stmp as $row) {
            $comment = Comment::fromDB($row);
            $comments[] = $comment;
        }
        return $comments;
    }
}
