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

// check if approve_comment is set
if (isset($_POST['approve_comment'])) {
    $commentObj = new Comment();

    // approve comment of given id
    $commentObj->setApproved($_POST['select_comment_id']);
}

?>


<article>
    <!-- Title with back button -->
    <h2>
        <a href="/admin">Back</a>
        Comments | Pending Moderation
    </h2>

    <div>
        <?php
        $commentObj = new Comment();
        // Get list of all comments
        $comments = $commentObj->getAllComments(0);     // only get list of non-approved comments

        // loop through all
        foreach ($comments as $comment) {
            // display each comment with name of article, user, and their links with option to approve
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