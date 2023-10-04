<?php
include 'header.php';
?>

<main>
    <div class="with-page-margin">
        <div>
            <div class="center-text bottom-border">
            <?php
                $user = User::withID($_GET['id']);

                echo '<h2 class="no-margin">'.$user->name.'</h2><br>';
                echo '<h3>@'.$user->username.'</h3><br>';

            ?>
            </div>
            <br><br>
        </div>
        <article>
            <h2>Articles</h2>
            <?php
            $user_id = $_GET['id'];

            $articleObj = new Article();
            $articles = $articleObj->getListFromAuthor($user_id);

            foreach ($articles as $article) {

                echo '<article>';
                echo '<a href=/article?id=' . $article->article_id . '>
                                <h3>' . $article->title . '</h3>
                                </a><br>';

                echo '<i>' . $article->post_datetime . '</i><br>';

                echo '<a href="user/?id=' . $article->user_id . '">' . ($article->author) . '</a><br><br>';
                if ($article->image_url != '') {
                    echo '<img class = "cover-img" src="' . $article->image_url . '"/>';
                }
                echo '<p>' . $article->body . '</p>';
                echo '<a href=/article?id=' . $article->article_id . '>
                            <b>...</b>
                            </a>';
                echo '<br><br><div id="view-count">' . $article->views . ' Views</div><br>';
                echo '</article>';
            }

            ?>
        </article>
        <comments>
            <h2>Comments</h2>
            <?php

            if (isset($_GET['id'])) {
                $user_id = $_GET['id'];
                $commentObj = new Comment();

                $comments = $commentObj->getCommentsFromUser($user_id);
                foreach ($comments as $comment) {
                    echo '
                            <comment-item>
                                <a href="/article/?id=' . $comment->article_id . '">Comment on: <b>' . $comment->article_title . '</b></a>
                                <p>' . $comment->comment_text . '</p>
                            </comment-item>
                        ';
                }
            }

            ?>

        </comments>
    </div>
</main>

<?php
include '../footer.php';
?>