<?php
    include 'header.php';
?>

<?php

function display_edit_post(){
    $categoryObj = new Category();
    $categories = array();
    $categories = $categoryObj->getListOfCategories();

    $categories_template = '';
    foreach($categories as $category){
        $name = $category->getName();
        $categories_template .= '<option value="'.($name).'">';
    }

    // Get the original Article
    $original_article = new Article();
    $original_article = $original_article->getArticleFromId($_GET['article_id']);

    // Now get the category name
    $categoryObj = new Category();
    $categoryObj = $categoryObj->getCategoryFromId($original_article->category_id);

    $edit_post_template = ('
        <article>
            <h2>
                <a href="/admin/posts.php">Back</a>
                Edit Story
            </h2>
            <form method="post">
                
                <!-- For passing article ID which is hidden from the user -->
                <input type="hidden" value='.$original_article->article_id.' name="article_id"/>
                
                <label>Title</label> <input type="text" name="title" placeholder="Article Heading" value = "'.$original_article->title.'"/>
                
                <label>Body</label> 
                <textarea name="body" placeholder="Start writing your awesome article!">'.$original_article->body.'</textarea>

                <label>Add Image</label> <input type="file" />
                <label>Category</label>

                <input list="categories" name="category" id="category" value = "'.$categoryObj->name.'">
                <datalist id="categories">
                    '.$categories_template.'
                </datalist>


                <label for="publish-toggle">Publish</label>
                <input type="checkbox" name="is_published" id="publish-toggle" checked = "'.$original_article->is_published.'">

                <input type="submit" name="submit" value="Submit" />
            </form>

        </article>
    ');
    echo $edit_post_template;
}

if(isset($_POST['submit'])){

    $article_id = $_POST['article_id'];
    $title = $_POST['title'];

    //TODO Get username from user_id
    $user_id = $_SESSION['user_id'];
    
    $body = $_POST['body'];

    //TODO Upload image and get the url
    $image_url = '    ';
    
    $category = Category::withName($_POST['category']);

    $category_id = $category->getId();

    $is_published = isset($_POST['is_published']) ? 1 : 0;

    $article = Article::fromParameters($title, $user_id, $body, $image_url, $category_id, $is_published);
    
    // Important For Updating Existing !!!
    $article->article_id = $article_id;
    
    $article->editPost();

    echo '<h1>Your post has been updated!</h1><br><br>'.
            '<h2 style = "text-align:center;"><a href="/admin/posts.php">View Posts</a></h2>';
}else{
    display_edit_post();
}


?>

<?php
    include 'footer.php';
?>