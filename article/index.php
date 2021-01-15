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
        $articleObj = new Article();

        if (isset($_GET['id'])) {
            $article = $articleObj->getArticleFromId($_GET['id']);
            $article->addViewCount();
            echo '<h2>' . $article->title . '</h2>';

            // echo '<i>'.$article->category_id.'</i>';
            echo '<i>' . $article->post_datetime . '</i><br>';

            echo '<a href="/user/?id=' . $article->user_id . '">' . ($article->author) . '</a><br><br>';


            if ($article->image_url != '') {
                echo '<img class = "cover-img" src="' . $article->image_url . '"/>';
            }
            $share = new Share();
            echo $share->getShareButtonTemplate();

            echo '<p>' . $article->body . '</p><br>';
            echo '<div id=view-count>' . $article->views . ' Views</div><br><br>';
        } else {
            $articles = array();
            $articles = $articleObj->getListOfArticles(Article::SORT_DEFAULT);

            foreach ($articles as $article) {

                echo '<article class="nested">';
                echo '<a href=/article?id=' . $article->article_id . '>
                                <h3>' . $article->title . '</h3>
                                </a><br>';

                // echo '<i>'.$article->category_id.'</i>';
                echo '<i>' . $article->post_datetime . '</i><br>';

                echo '<a href="/user/?id=' . $article->user_id . '">' . ($article->author) . '</a><br><br>';
                echo '<p>' . $article->body . '</p>';
                echo '<a href=/article?id=' . $article->article_id . '>
                            <b>...</b>
                            </a>';
                echo '<br><br><div id="view-count">' . $article->views . ' Views</div><br>';
                echo '</article>';
            }
        }


        echo '<comments> <h3>Comments</h3>';

        $write_comment_template = '
                    <form method="POST">
                        <input type="hidden" name="article_id" value = "' . $article->article_id . '">
                        <label for="comment_text">Post a comment</label>
                        <textarea name="comment_text" id="comment_text" placeholder="Your comment here..."></textarea>
                        <input type="submit" value="Comment">
                    </form>
            ';

        $user = User::current();
        if ($user->isLoggedIn()) echo $write_comment_template;

        $commentObj = new Comment();
        $comments = $commentObj->getCommentsForId($article->article_id);

        foreach ($comments as $comment) {
            echo '
                <comment-item>
                    <a href="/user/?id=' . $comment->user_id . '"><h4>' . $comment->user_name . '</h4></a>
                    <p>' . $comment->comment_text . '</p>';

            if ($user->isLoggedIn()) echo
                '
                <a class="reply-btn" href="?id=' . $article->article_id . '&reply-to=' . $comment->comment_id . '">Reply</a>
                ';

            echo '</comment-item>';

            $replyObj = new CommentReply();
            $replies = $replyObj->getReplies($comment->comment_id);

            foreach ($replies as $reply) {
                echo '
                    <comment-item class="reply-comment">
                        <a href="/user/?id=' . $reply->user_id . '"><b>' . $reply->user_name . '</b> replied:</a>
                        <p>' . $reply->comment_text . '</p>
                    </comment-item>
                ';
            }
            if (isset($_GET['reply-to']) && $_GET['reply-to'] == $comment->comment_id) {

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