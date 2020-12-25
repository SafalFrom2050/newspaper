<?php
    include 'header.php';
?>
<article>
    <h2>
        <a href="/admin">Back</a>
        All Posts
    </h2>

    <?php
        $articleObj = new Article();
        $articles = array();
        $articles = $articleObj->getListOfArticles();

        foreach($articles as $article){
            echo '<div class = "post-preview">';

            echo '<h3>'.$article->title.
                    '<a href="/admin/edit-post.php?article_id='.$article->article_id.'">Edit</a>
                  </h3>';

            echo '<i>'.$article->category_id.'</i>';
            echo '<i>'.$article->post_datetime.'</i><br>';
            
            echo '<a href="user/id?='.$article->author.'">'.($article->author).'</a><br><br>';

            echo '</div>';
        }
    ?>

</article>

<?php
    include 'footer.php';
?>