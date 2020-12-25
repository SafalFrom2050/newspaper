<?php
    include 'header.php';
?>

    <article>
    	<h2>Welcome To Admin Section</h2>
        <p>This area is only for admistrators and news publishers. Here is a brief description of all the options you can use:</p>
        

        <h3>News Article</h3><br>
        <p>Manage all your stories from this section.</p>

		<ul>
            <li><a href="create-story.php">Add New Story</a></li>
			<li><a href="posts.php">All Posts</a></li>
		</ul>

        <h3>Category</h3><br>
        <p>View, create or edit existing categories.</p>
		<ul>
			<li><a href="#">Edit Categories</a></li>
		</ul>

        <h3>Comments</h3><br>
        <p>Monitor comments and have the full control over what is allowed on your article.</p>
        <ul>
			<li><a href="#">Recent Comments</a></li>
			<li><a href="#">Pending Moderation</a></li>
		</ul>

    </article>

<?php
    include 'footer.php';
?>