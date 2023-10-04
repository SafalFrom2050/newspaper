<?php
session_start();
include 'header.php';


// Only for article view due to security concerns
header('Access-Control-Allow-Origin: *');
?>

<?php

if (isset($_POST['article_id']) && isset($_POST['comment_text'])) {
    $comment_text = $_POST['comment_text'];
    $article_id = $_POST['article_id'];


    // Comment Validator
    if (strlen($comment_text) > 0) {
        $commentObj = Comment::createComment($comment_text, $article_id);

        // Check if the comment is reply to another comment
        if (isset($_POST['reply_to'])) {
            $reply_to = $_POST['reply_to'];
            $replyObj = new CommentReply();
            $replyObj->postReply($reply_to, $commentObj);
        } else {
            $commentObj->postComment();
        }
    }
}

?>


<main>
    <article>

        <?php
        // create article object
        $articleObj = new Article();

        // check is id is in GET parameter
        if (isset($_GET['id'])) {
            // if yes, create an article object of that article id
            $article = $articleObj->getArticleFromId($_GET['id']);

            // Increment views count
            $article->addViewCount();

            // Display Article data

            echo '<h2>' . $article->title . '</h2>';

            // Formats the date in 'dd-mm-yy'' format
            $date = new DateTime($article->post_datetime);
            echo '<i>' . $date->format('d-m-Y') . '</i><br>';

            echo '<a href="/user/?id=' . $article->user_id . '">' . ($article->author) . '</a><br><br>';


            // If no image is assigned, don't echo image
            if ($article->image_url != '') {
                echo '<img class = "cover-img" src="' . $article->image_url . '"/>';
            }

            // initialize share options
            $share = new Share();
            echo $share->getShareButtonTemplate();

            echo '<p>' . $article->body . '</p><br>';

            // Show view count
            echo '<div id=view-count>' . $article->views . ' Views</div><br><br>';
        } else {
            // Create array of article objects retrieved from database
            $articles = array();
            $articles = $articleObj->getListOfArticles(Article::SORT_DEFAULT);

            // loop throught all articles
            foreach ($articles as $article) {

                // display each article, like a list view
                echo '<article class="nested">';
                echo '<a href=/article?id=' . $article->article_id . '>
                                <h3>' . $article->title . '</h3>
                                </a><br>';

                // Formats the date in 'dd-mm-yy'' format
                $date = new DateTime($article->post_datetime);
                echo '<i>' . $date->format('d-m-Y') . '</i><br>';

                echo '<a href="/user/?id=' . $article->user_id . '">' . ($article->author) . '</a><br><br>';
                echo '<p>' . $article->body . '</p>';
                echo '<a href=/article?id=' . $article->article_id . '>
                            <b>...</b>
                            </a>';
                echo '<br><br><div id="view-count">' . $article->views . ' Views</div><br>';
                echo '</article>';
            }
        }

        // Comment section

        echo '<comments> <h3>Comments</h3>';

        // html form template of write comment box
        $write_comment_template = '
                    <form method="POST">
                        <input type="hidden" name="article_id" value = "' . $article->article_id . '">
                        <label for="comment_text">Post a comment</label>
                        <textarea name="comment_text" id="comment_text" placeholder="Your comment here..."></textarea>
                        <input type="submit" value="Comment">
                    </form>
            ';

        // check is the user is logged in or not
        $user = User::current();

        // only show write comment template if the user is loggged in
        if ($user->isLoggedIn()) echo $write_comment_template;


        // Anyone can view comments, so initialize comment object
        $commentObj = new Comment();

        // And get the list of all comments
        $comments = $commentObj->getCommentsForId($article->article_id);

        // loop through all
        foreach ($comments as $comment) {
            // display comment
            echo '
                <comment-item>
                    <a href="/user/?id=' . $comment->user_id . '"><h4>' . $comment->user_name . '</h4></a>
                    <p>' . $comment->comment_text . '</p>';

            // Only display reply button if the user is logged in
            if ($user->isLoggedIn()) echo
            '
                <a class="reply-btn" href="?id=' . $article->article_id . '&reply-to=' . $comment->comment_id . '">Reply</a>
                ';

            echo '</comment-item>';

            // get list of replies for this comment
            $replyObj = new CommentReply();
            $replies = $replyObj->getReplies($comment->comment_id);

            // Loop through all replies
            foreach ($replies as $reply) {
                // Show nested comments
                echo '
                    <comment-item class="reply-comment">
                        <a href="/user/?id=' . $reply->user_id . '"><b>' . $reply->user_name . '</b> replied:</a>
                        <p>' . $reply->comment_text . '</p>
                    </comment-item>
                ';
            }

            // Check is the reply-to GET parameter is set
            if (isset($_GET['reply-to']) && $_GET['reply-to'] == $comment->comment_id) {
                // display reply box, nested below this comment
                echo '
                    <comment-item class="reply-comment">' . $comment->createWriteReplyTemplate() .
                    '<h5>Replying as: ' . $user->name  . '</h5>
                    </comment-item>
                     
                ';
            }
        }

        echo '</comments>';

        ?>

    </article>
</main>
<?php
include '../footer.php';
?>