<?php
session_start();
include 'header.php';
?>

<main>
    <nav>
        <?php
        $user = new User();

        // Check if the user is admin to show or not show Admin controls
        $isAdmin = $user->isAdmin();
        if ($isAdmin) {
            // show admin controls on side nav
            echo '<h3>Controls</h3>';
            echo '<ul><li>';

            echo '<a href="/admin">Admin Panel</a>';
            echo '</li></ul>';
        }
        ?>

        <!-- Search form -->
        <h3>Search</h3>
        <ul>
            <li>
                <form method="GET" class="search-box">
                    <input type="text" name="search" placeholder="Search a title...">
                    <input type="submit" value="Go">
                </form>
            </li>
        </ul>

        <!-- Sort by options -->
        <h3>Sort By </h3>
        <ul>
            <li>
                <form name="sort_by_form" class="sort-by-form" method="GET">

                    <!-- Simple javascript on onchange to submit form on change without submit button click -->
                    <select name="sort-by" onchange="sort_by_form.submit()">
                        <?php
                        // options template
                        $_popular = '<option value="0">Popular</option>';
                        $_latest = '<option value="1">Latest</option>';
                        $_oldest = '<option value="2">Oldest</option>';
                        $_longest = '<option value="3">Longest</option>';
                        $_shortest = '<option value="4">Shortest</option>';

                        // create array of options template to make it easier to sorta
                        $_sort_items = array(
                            0 => $_latest,
                            1 => $_popular,
                            2 => $_oldest,
                            3 => $_longest,
                            4 => $_shortest
                        );

                        // Determine which element is selected and thus should be on top
                        if (isset($_GET['sort-by'])) {
                            if ($_GET['sort-by'] == Article::SORT_BY_LONGEST) {
                                $_sort_items = array(0 => $_longest) + array(Article::SORT_BY_LONGEST => $_latest) + $_sort_items;
                            } else if ($_GET['sort-by'] == Article::SORT_BY_SHORTEST) {
                                $_sort_items = array(0 => $_shortest) + array(Article::SORT_BY_SHORTEST => $_latest) + $_sort_items;
                            } else if ($_GET['sort-by'] == Article::SORT_BY_POPULARITY) {
                                $_sort_items = array(0 => $_popular) + array(Article::SORT_BY_LATEST => $_latest) + $_sort_items;
                            } else if ($_GET['sort-by'] == Article::SORT_BY_OLDEST) {
                                $_sort_items = array(0 => $_oldest) + array(Article::SORT_BY_OLDEST => $_latest) + $_sort_items;
                            }
                        }

                        // display sorted option items
                        foreach ($_sort_items as $key => $value) {
                            echo $value;
                        }
                        ?>
                    </select>

                    <?php
                    // check if category is set in GET
                    if (isset($_GET['category'])) {
                        echo '<input type = "hidden" name = "category" value ="' . $_GET['category'] . '">';
                    }
                    ?>
                </form>
            </li>
        </ul>

        <!-- Account in nav bar -->
        <h3>Account</h3>
        <ul>
            <?php
            // show relavant options according to user login status
            if (User::isLoggedIn()) {
                echo '
                        <li><a href="/account">My Account</a></li>
                        <li><a href="/account/logout.php">Logout</a></li>
                    ';
            } else {
                echo '
                        <li><a href="/account/login.php">Login</a></li>
                        <li><a href="/account/signup.php">Create Account</a></li>
                    ';
            }
            ?>

        </ul>
    </nav>

    <!-- List of articles -->
    <article>

        <?php
        // set the title and only published to be displayed true
        $title = 'Latest';
        $only_published = true;

        $articleObj = new Article();

        // get the sort value and change title accordingly
        $sort = Article::SORT_DEFAULT;
        if (isset($_GET['sort-by'])) {
            if ($_GET['sort-by'] == Article::SORT_BY_POPULARITY) {
                $title = 'Popular';
            } else if ($_GET['sort-by'] == Article::SORT_BY_OLDEST) {
                $title = 'Oldest';
            } else if ($_GET['sort-by'] == Article::SORT_BY_LONGEST) {
                $title = 'Longest';
            } else if ($_GET['sort-by'] == Article::SORT_BY_SHORTEST) {
                $title = 'Shortest';
            }
            $sort = $_GET['sort-by'];
        }

        // get the category value and change the title accordingly
        if (isset($_GET['category'])) {
            $category_id = $_GET['category'];

            $title .= ' In > ' . Category::withID($category_id)->name . '';
            $articles = $articleObj->getListFromCategory($category_id, $sort, $only_published);
        } else if (isset($_GET['search'])) {
            // if search value is set, change title accordingly
            $title = 'Search Results';
            $articles = $articleObj->searchArticles($_GET['search']);
        } else {

            // otherwise, set default title and load using default sort
            $articles = $articleObj->getListOfArticles($sort, $only_published);
        }

        // start showing articles
        echo '<h2>' . $title . ' </h2><br>';

        foreach ($articles as $article) {

            echo '<article class="nested">';
            echo '<a href=/article?id=' . $article->article_id . '>
                            <h3>' . $article->title . '</h3>
                            </a><br>';

            // Formats the date in 'dd-mm-yy'' format
            $date = new DateTime($article->post_datetime);
            echo '<i>' . $date->format('d-m-Y') . '</i><br>';

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

</main>


<?php
include 'footer.php';
?>