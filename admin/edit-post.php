<?php
include 'header.php';
?>

<?php
// function to display edit post html form template
function display_edit_post()
{
    $post = new Post();

    // display edit post html form template
    echo $post->generateEditPostTemplate();
}

// check if submit is set
if (isset($_POST['submit'])) {
    $post = new Post();

    // Post the article where edit parameter is set to true(handlePost funtion will treat it as edit to existing)
    $post->handlePost(true);

    echo '<h1>Your post has been updated!</h1><br><br>' .
        '<h2 style = "text-align:center;"><a href="/admin/posts.php">View Posts</a></h2>';
} else {
    // show edit post form
    display_edit_post();
}


?>
</main>
<?php
include '../footer.php';
?>