<?php
include 'header.php';
?>

<?php

if (isset($_POST['delete_comment'])) {
    $commentObj = new Comment();
    $commentObj->delete($_POST['select_comment_id']);
}

if (isset($_POST['approve_comment'])) {
    $commentObj = new Comment();
    $commentObj->setApproved($_POST['select_comment_id']);
}

?>


<article>
    <h2>
        <a href="/admin">Back</a>
        Comments | Pending Moderation
    </h2>

    <div>
        <?php
        $commentObj = new Comment();
        $comments = $commentObj->getAllComments(0);     // only get list of non-approved comments

        foreach ($comments as $comment) {
            echo '<div class="comments-moderation-list-item">';

            echo ' 
                        <comment-item class="no-margin">
                            <a href="/article/?id=' . $comment->article_id . '">Comment on: <b>' . $comment->article_title . '</b></a>
                            
                            <p>' . $comment->comment_text . '</p><br>
                            <a href="/user/?id=' . $comment->user_id . '">By: <b>' . $comment->user_name . '</b></a>
                            <h3>
                            <form method="POST" onsubmit="return confirm(`Confirm this approval/disapproval?`);">
                                <input type="hidden" name="select_comment_id" value="' . $comment->comment_id . '" />
                                <input type="submit" name="delete_comment" value="Delete" >
                                <input type="submit" name="approve_comment" value ="Approve" >
                            </form>
                            </h3>
                        </comment-item>
                        
                    ';
            echo '</div>';
        }
        ?>
    </div>

</article>
</main>
<?php
include '../footer.php';
?>