<?php
include 'header.php';
?>

<?php

// check if delete_article_id is set
if (isset($_POST['delete_article_id'])) {
    $articleObj = new Article();
    $articleObj = $articleObj->getArticleFromId($_POST['delete_article_id']);

    // delete article of given id
    $articleObj->deleteArticle();
}

?>

<article>
    <!-- Title with back button -->
    <h2>
        <a href="/admin">Back</a>
        All Posts
    </h2>

    <?php
    $articleObj = new Article();
    $articles = array();

    // list of articles
    $articles = $articleObj->getListOfArticles(Article::SORT_DEFAULT, -1);

    // loop through all
    foreach ($articles as $article) {

        // show details of article
        echo '<div class = "post-preview">';

        echo '<h3>' . $article->title .
            '
            <form method="POST" onsubmit="return confirm(`Do you want to delete this article?`);">
                <input type="hidden" name="delete_article_id" value="' . $article->article_id . '" />
                <input type="submit" value ="Delete" />
            </form>
            <a href="/admin/edit-post.php?article_id=' . $article->article_id . '">Edit</a>
              </h3>';

        echo '<i>' . $article->post_datetime . '</i><br>';

        echo '<a href="/user?id=' . $article->user_id . '">' . ($article->author) . '</a>';

        echo '</div>';
    }
    ?>

</article>
</main>
<?php
include '../footer.php';
?>