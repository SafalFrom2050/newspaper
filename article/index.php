<?php
    session_start();
    include 'header.php';


    // Only for article view due to security concerns
    header('Access-Control-Allow-Origin: *');  
?>

<?php
    
    if(isset($_POST['article_id']) && isset($_POST['comment_text'])){
        $comment_text = $_POST['comment_text'];
        $article_id = $_POST['article_id'];
        
        $commentObj = Comment::createComment($comment_text, $article_id);
        $commentObj->postComment();
    }

?>


<main>
    <article>
    
        <?php
            $articleObj = new Article();

            if(isset($_GET['id'])){
                $article = $articleObj->getArticleFromId($_GET['id']);

                echo '<h2>'.$article->title.'</h2>';
    
                // echo '<i>'.$article->category_id.'</i>';
                echo '<i>'.$article->post_datetime.'</i><br>';
                
                echo '<a href="user/id?='.$article->author.'">'.($article->author).'</a><br><br>';

                if(!is_null($article->image_url)){
                    echo '<img class = "cover-img" src="'.$article->image_url.'"/>';
                }

                echo '<p>'.$article->body.'</p><br><br>';
               
            }else{
                $articles = array();
                $articles = $articleObj->getListOfArticles(Article::SORT_DEFAULT);

                foreach($articles as $article){

                    echo '<a href=/article?id='.$article->article_id.'>
                            <h3>'.$article->title.'</h3>
                            </a><br>';
    
                    // echo '<i>'.$article->category_id.'</i>';
                    echo '<i>'.$article->post_datetime.'</i><br>';
                    
                    echo '<a href="user/id?='.$article->author.'">'.($article->author).'</a><br><br>';
                    echo '<p>'.$article->body.'</p><br><br>';
                }
            }


            echo '<comments> <h3>Comments</h3>';

            $write_comment_template = '
                    <form method="POST">
                        <input type="hidden" name="article_id" value = "'.$article->article_id.'">
                        <label for="comment_text">Post a comment</label>
                        <textarea name="comment_text" id="comment_text" placeholder="Your comment here..."></textarea>
                        <input type="submit" value="Comment">
                    </form>
            ';

            $user = new User();
            if($user->isLoggedIn()) echo $write_comment_template;

            $commentObj = new Comment();
            $comments = $commentObj->getCommentsForId($article->article_id);

            foreach($comments as $comment){
                echo '
                    <comment-item>
                        <a href="/user/id='.$comment->user_id.'"><h4>'.$comment->user_name.'</h4></a>
                        <p>'.$comment->comment_text.'</p>
                    </comment-item>
                ';
            }

            echo '</comment>';
        
        ?>

    </article>
</main>
<?php
    include 'footer.php';
?>