<?php
include 'header.php';
?>

<?php



// function to display create post html form template
function display_create_post()
{
    $post = new Post();
    // display create post html form template
    echo $post->generateCreatePostTemplate();
}

// check if submit is set
if (isset($_POST['submit'])) {
    $post = new Post();

    // post the article
    $post->handlePost();

    // show success message
    echo '<h1>Your post has been added!</h1><br><br>' .
        '<h2 style = "text-align:center;"><a href="/admin/create-story.php">Add New</a></h2>';
} else {
    // display create article form
    display_create_post();
}

?>
</main>
<?php
include '../footer.php';
?>