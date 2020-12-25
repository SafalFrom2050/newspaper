<?php
    include 'header.php';
?>

<?php

function display_create_post(){
    $categoryObj = new Category();
    $categories = array();
    $categories = $categoryObj->getListOfCategories();

    $categories_template = '';
    foreach($categories as $category){
        $name = $category->getName();
        $categories_template .= '<option value="'.($name).'">';
    }

    $create_post_template = ('
        <article>
            <h2>
                <a href="/admin">Back</a>
                Add New Story
            </h2>
            <form method="post">

                <label>Title</label> <input type="text" name="title" placeholder="Article Heading"/>
                <label>Body</label> <textarea name="body" placeholder="Start writing your awesome article!"></textarea>

                <label>Add Image</label> <input type="file" />
                <label>Category</label>

                <input list="categories" name="category" id="category">
                <datalist id="categories">
                    '.$categories_template.'
                </datalist>


                <label for="publish-toggle">Publish</label>
                <input type="checkbox" name="is_published" id="publish-toggle">

                <input type="submit" name="submit" value="Submit" />
            </form>

        </article>
    ');
    echo $create_post_template;
}

if(isset($_POST['submit'])){

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

    $article->postArticle();

    echo '<h1>Your post has been added!</h1><br><br>'.
            '<h2 style = "text-align:center;"><a href="/admin/create-story.php">Add New</a></h2>';
}else{
    display_create_post();
}


?>

<?php
    include 'footer.php';
?>