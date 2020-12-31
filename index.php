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
        
        <h3>Search</h3>
        <ul>
            <li>
                <form method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Search a title...">
                    <input type="submit" value="Go">
                </form>
            </li>
        </ul>

        <h3>Sort By </h3>
        <ul>
            <li>
                <form name = "sort_by_form" class = "sort-by-form" method="GET">
                        
                        <select name="sort-by" onchange="sort_by_form.submit()">
                        <?php

                            $_all = '<option value="0">Popular</option>';
                            $_latest = '<option value="1">Latest</option>';
                            $_oldest = '<option value="2">Oldest</option>';
                            $_longest = '<option value="3">Longest</option>';
                            $_shortest = '<option value="4">Shortest</option>';
                            
                            $_sort_items = array(
                                0 => $_all,
                                1 => $_latest,
                                2 => $_oldest,
                                3 => $_longest,
                                4 => $_shortest
                            );

                        
                            if(isset($_GET['sort-by'])){
                                if($_GET['sort-by'] == Article::SORT_BY_LONGEST){
                                    $_sort_items = array(0 => $_longest) + array(Article::SORT_BY_LONGEST => $_all) + $_sort_items;
                                }else if($_GET['sort-by'] == Article::SORT_BY_SHORTEST){
                                    $_sort_items = array(0 => $_shortest) + array(Article::SORT_BY_SHORTEST => $_all) + $_sort_items;
                                }else if($_GET['sort-by'] == Article::SORT_BY_LATEST){
                                    $_sort_items = array(0 => $_latest) + array(Article::SORT_BY_LATEST => $_all) + $_sort_items;
                                }else if($_GET['sort-by'] == Article::SORT_BY_OLDEST){
                                    $_sort_items = array(0 => $_oldest) + array(Article::SORT_BY_OLDEST => $_all) + $_sort_items;
                                }
                            }

                            foreach($_sort_items as $key=>$value){
                                echo $value;
                            }
                        ?>  
                        </select>

                        <?php
                            if(isset($_GET['category'])){
                                echo '<input type = "hidden" name = "category" value ="'.$_GET['category'].'">';
                            }
                        ?>
                </form>
            </li>
        </ul>
	</nav>
    
    <article>
    
        <?php
            $title = 'Popular';
            $only_published = true;

            $articleObj = new Article();
            $articles = array();

            $sort = Article::SORT_DEFAULT;
            if(isset($_GET['sort-by'])){
                if($_GET['sort-by'] == Article::SORT_BY_LATEST){
                    $title = 'Latest';
                }else if($_GET['sort-by'] == Article::SORT_BY_OLDEST){
                    $title = 'Oldest';
                }else if($_GET['sort-by'] == Article::SORT_BY_LONGEST){
                    $title = 'Longest';
                }else if($_GET['sort-by'] == Article::SORT_BY_SHORTEST){
                    $title = 'Shortest';
                }
                $sort = $_GET['sort-by'];
            }

            if(isset($_GET['category'])){
                $category_id = $_GET['category'];
                
                $title .= ' In > '.Category::withID($category_id)->name.'';
                $articles = $articleObj->getListFromCategory($category_id, $sort, $only_published); 
            }else{
                
                $articles = $articleObj->getListOfArticles($sort, $only_published);
            }

            echo '<h2>'.$title.' </h2><br>'; 

            foreach($articles as $article){

                echo '<article class="nested">';
                echo '<a href=/article?id='.$article->article_id.'>
                            <h3>'.$article->title.'</h3>
                            </a><br>';

                // echo '<i>'.$article->category_id.'</i>';
                echo '<i>'.$article->post_datetime.'</i><br>';
                
                echo '<a href="user/id?='.$article->author.'">'.($article->author).'</a><br><br>';
                echo '<p>'.$article->body.'</p>';
                echo '<a href=/article?id='.$article->article_id.'>
                        <b>...</b>
                        </a>';
                echo '<br><br><div id="view-count">'.$article->views.' Views</div><br>'; 
                echo '</article>';
            }
        ?>
    </article>

</main>


<?php
    include 'footer.php';
?>