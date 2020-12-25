<?php
    session_start();
    include 'header.php';
?>

<main>
	<nav>

        <h3>Controls</h3>
		<ul>
            <?php
                $user = new User();

                 $isAdmin = $user->isAdmin();
                 if($isAdmin){
                     echo '<li><a href="/admin">Admin Panel</a></li>';
                 }
            ?>	
        </ul>
        <ul>
            <li>
                <form name = "sort_by_form" class = "sort-by-form" method="GET">
                        <label for="sort-by"><h3>Sort By </h3></label>

                        <select name="sort-by" onchange="sort_by_form.submit()">
                        <?php
                            $_latest = '<option value="1">Latest</option>';
                            $_all = '<option value="0">All</option>';
                            if(isset($_GET['sort-by']) && $_GET['sort-by'] == Article::SORT_BY_LATEST){
                                echo $_latest;
                                echo $_all;
                            }else{
                                echo $_all;
                                echo $_latest;
                            }
                        ?>  
                        </select>
                </form>
            </li>
        </ul>
	</nav>
    
    <article>
    
        <?php
            $articleObj = new Article();
            $articles = array();

            $sort = 0;
            if(isset($_GET['sort-by']) && $_GET['sort-by'] == Article::SORT_BY_LATEST){
                $sort = Article::SORT_BY_LATEST;
                echo '<h2> Latest Articles </h2>';
            }else{
                echo '<h2> Popular News </h2>';
            }
            $articles = $articleObj->getListOfArticles($sort);

            foreach($articles as $article){

                echo '<h3>'.$article->title.'</h3>';

                echo '<i>'.$article->category_id.'</i>';
                echo '<i>'.$article->post_datetime.'</i><br>';
                
                echo '<a href="user/id?='.$article->author.'">'.($article->author).'</a><br><br>';
                echo '<p>'.$article->body.'</p><br><br>';
            }
        ?>
    </article>

</main>


<?php
    include 'footer.php';
?>