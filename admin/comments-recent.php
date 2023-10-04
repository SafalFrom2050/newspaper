<?php
include 'header.php';
?>

<?php

// check if delete_comment is set
if (isset($_POST['delete_comment'])) {
    $commentObj = new Comment();

    // delete comment
    $commentObj->delete($_POST['select_comment_id']);
}

?>

<article>
    <!-- Title with back button -->
    <h2>
        <a href="/admin">Back</a>
        Comments | Recent
    </h2>

    <div>
        <?php
        $commentObj = new Comment();
        // get list of all approved
        $comments = $commentObj->getAllComments(1);     // only get list of approved comments

        // loop through all
        foreach ($comments as $comment) {

            // show each with an option to delete
            echo '<div class="comments-moderation-list-item">';

            echo ' 
                        <comment-item class="no-margin">
                            <a href="/article/?id=' . $comment->article_id . '">Comment on: <b>' . $comment->article_title . '</b></a>
                            
                            <p>' . $comment->comment_text . '</p><br>
                            <a href="/user/?id=' . $comment->user_id . '">By: <b>' . $comment->user_name . '</b></a>
                            <h3>
                            <form method="POST" onsubmit="return confirm(`Delete this comment?`);">
                                <input type="hidden" name="select_comment_id" value="' . $comment->comment_id . '" />
                                <input type="submit" name="delete_comment" value="Delete" >
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