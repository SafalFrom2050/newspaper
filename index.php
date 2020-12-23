<?php
    session_start();
    include 'functions/checks.php';
    include 'utils/auth_check.php';
    include 'header.php';

    include ('classes/article.php');
?>

<main>
	<nav>
		<ul>
            <?php
                 $isAdmin =isCurrentUserAdmin();
                 if($isAdmin){
                     echo '<li><a href="/admin">Admin Panel</a></li>';
                 }
            ?>
			
		</ul>
	</nav>

    <article>
        <h2> Popular News </h2>

        <?php
            $articles = array();
            $articles = getListOfArticles();

            foreach($articles as $article){

                echo '<h3>'.$article->title.'</h3>';

                echo '<i>'.$article->category_id.'</i>';
                echo '<i>'.$article->date.'</i>';
                
                echo '<li><a href="user/id?='.$article->author.'">'.($article->author).'</a></li>';
                echo '<p>'.$article->body.'</p><br><br>';
            }
        ?>
    </article>

</main>


<?php
    include 'footer.php';
?>