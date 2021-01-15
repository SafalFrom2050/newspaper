<?php
    include 'header.php';
?>

<?php

    

    function display_create_post(){
        $post = new Post();
        echo $post->generateCreatePostTemplate();
    }

    if(isset($_POST['submit'])){
        $post = new Post();
        $post->handlePost();

        echo '<h1>Your post has been added!</h1><br><br>'.
                '<h2 style = "text-align:center;"><a href="/admin/create-story.php">Add New</a></h2>';
    }else{
        display_create_post();
    }

?>
</main>
<?php
    include '../footer.php';
?>