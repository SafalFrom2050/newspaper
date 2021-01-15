<?php

class Comment extends Database
{
    public $comment_id;

    //Required
    public $user_id;
    public $user_name;
    public $article_id;
    public $comment_text;
    //

    //Comment ID
    public $reply_to;

    public $post_datetime;
    public $is_approved;
    public $article_title;


    public function __construct()
    {
    }

    public static function fromDB($row)
    {
        $instance = new self();

        $instance->comment_id = $row['comment_id'];
        $instance->comment_text = $row['comment_text'];
        $instance->post_datetime = $row['post_datetime'];
        $instance->is_approved = $row['is_approved'];
        $instance->article_id = $row['article_id'];
        $instance->reply_to = $row['reply_to'];
        $instance->user_id = $row['user_id'];
        $instance->user_name = $row['name'];

        // Optional
        if (isset($row['title'])) {
            $instance->article_title = $row['title'];
        }

        return $instance;
    }

    public static function createComment($comment_text, $article_id)
    {
        $instance = new self();

        $instance->comment_text = $comment_text;
        $instance->article_id = $article_id;

        $user = new User();
        $instance->user_id = $user->user_id;

        //Approve all admins commments
        if ($user->isAdmin()) {
            $instance->is_approved = true;
        } else {
            $instance->is_approved = false;
        }

        return $instance;
    }

    public function postComment($comment = null)
    {

        if (is_null($comment)) {
            $comment = $this;
        }


        $sql = 'INSERT INTO `comments`(`comment_text`, `user_id`, `is_approved`, `article_id`)
        VALUES (:comment_text, :user_id, :is_approved, :article_id)';

        $criteria = [
            'comment_text' => $comment->comment_text,
            'user_id' => $comment->user_id,
            'is_approved' => $comment->is_approved,     // Admin comments are automatically set to approve immediately
            'article_id' => $comment->article_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        return $stmp;
    }

    public function getCommentsForId($article_id = null)
    {

        if (!is_null($article_id)) {
            $comment = $this;
            $comment->article_id = $article_id;
        }

        $sql = 'SELECT `comments`.*, `articles`.`article_id`, `users`.`name` FROM `comments` 
                JOIN `articles` ON `comments`.`article_id`=`articles`.`article_id` 
                AND `comments`.`article_id` = :article_id 
                AND `comments`.`reply_to` IS NULL 
                AND `comments`.`is_approved`=1
                JOIN `users` ON `comments`.`user_id`=`users`.`user_id`;';

        $criteria = [
            'article_id' => $comment->article_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $comments = array();

        foreach ($stmp as $row) {
            $comment = Comment::fromDB($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function getCommentsFromUser($user_id = null)
    {

        if (is_null($user_id)) {
            $user_id = $this->user_id;
        }

        $sql = 'SELECT `comments`.*, `articles`.`article_id`, `articles`.`title`, `users`.`name` FROM `comments` 
                JOIN `users` ON `comments`.`user_id`=`users`.`user_id`
                AND `comments`.`user_id` = :user_id
                AND `comments`.`is_approved`=1
                JOIN `articles` ON `comments`.`article_id`=`articles`.`article_id`;
                ';

        $criteria = [
            'user_id' => $user_id
        ];

        $stmp = $this->executeWithCriteria($sql, $criteria);

        $comments = array();

        foreach ($stmp as $row) {
            $comment = Comment::fromDB($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    public function getAllComments($is_approved = -1)
    {
        //check if approval filter is selected
        if ($is_approved == -1) {
            // if default value(-1), then no filter applied
            $sql = 'SELECT `comments`.*, `articles`.`article_id`, `articles`.`title`, `users`.`name` FROM `comments` 
                JOIN `articles` ON `comments`.`article_id`=`articles`.`article_id`
                JOIN `users` ON `comments`.`user_id`=`users`.`user_id`;';

            $stmp = $this->executeSql($sql);
        } else {
            // Add is_approved criteria to the sql query if given
            $sql = 'SELECT `comments`.*, `articles`.`article_id`, `articles`.`title`, `users`.`name` FROM `comments` 
                JOIN `articles` ON `comments`.`article_id`=`articles`.`article_id`
                AND `comments`.`is_approved`=:is_approved
                JOIN `users` ON `comments`.`user_id`=`users`.`user_id`;';

            $criteria = [
                'is_approved' => $is_approved
            ];

            $stmp = $this->executeWithCriteria($sql, $criteria);
        }


        $comments = array();
        foreach ($stmp as $row) {
            $comment = Comment::fromDB($row);
            $comments[] = $comment;
        }
        return $comments;
    }

    // Function to change approval status
    public function setApproved($comment_id, $is_approved = 1)
    {
        $this->comment_id = $comment_id;
        $this->is_approved = $is_approved;

        $sql = 'UPDATE `comments` SET `is_approved`=:is_approved
            WHERE `comment_id`=:comment_id';

        $criteria = [
            'comment_id' => $comment_id,
            'is_approved' => $is_approved
        ];

        $this->executeWithCriteria($sql, $criteria);
    }

    // Funtion to delete comments
    public function delete($comment_id = null)
    {
        if (is_null($comment_id)) {
            $comment_id = $this->comment_id;
        }

        $sql = 'DELETE FROM `comments` WHERE comment_id=:comment_id';

        $criteria = [
            'comment_id' => $comment_id
        ];

        $this->executeWithCriteria($sql, $criteria);
    }

    public function createWriteReplyTemplate()
    {
        $reply_comment_template = '
            <form method="POST">
                <input type="hidden" name="article_id" value = "' . $this->article_id . '">
                <input type="hidden" name="reply_to" value = "' . $this->comment_id . '">
                <label for="comment_text">Write a reply</label>
                <textarea name="comment_text" id="comment_text" placeholder="Your reply here..."></textarea>
                <input type="submit" value="Reply">
            </form>
            ';
        return $reply_comment_template;
    }
}
