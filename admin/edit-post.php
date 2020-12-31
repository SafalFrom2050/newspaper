<?php
    include 'header.php';
?>

<?php

    function display_edit_post(){
        $post = new Post();
        echo $post->generateEditPostTemplate();
    }

    if(isset($_POST['submit'])){
        $post = new Post();
        $post->handlePost(true);

        echo '<h1>Your post has been updated!</h1><br><br>'.
                '<h2 style = "text-align:center;"><a href="/admin/posts.php">View Posts</a></h2>';
    }else{
        display_edit_post();
    }


?>

<?php
    include 'footer.php';
?>