<?php
include 'header.php';
?>

<article>
    <h2>Welcome To Admin Section</h2>
    <p>This area is only for admistrators and news publishers. Here is a brief description of all the options you can use:</p>

    <br>
    <h3>News Article</h3><br>
    <p>Manage all news articles or stories from this section.</p>

    <ul>
        <li><a href="create-story.php">Add New Story</a></li>
        <li><a href="posts.php">All Posts</a></li>
    </ul>
    <br>
    <h3>Category</h3><br>
    <p>View, create or edit existing categories.</p>
    <ul>
        <li><a href="categories.php">Manage Categories</a></li>
    </ul>

    <br>
    <h3>Comments</h3><br>
    <p>Monitor comments and have the full control over what is allowed on your article.</p>
    <ul>
        <li><a href="comments-recent.php">Recent Comments</a></li>
        <li><a href="comments-moderation.php">Pending Moderation</a></li>
    </ul>

    <br>
    <h3>Users</h3><br>
    <p>Manage all the user accounts including admins.</p>
    <ul>
        <li><a href="account-users.php">View All</a></li>
        <li><a href="account-admins.php">Admins</a></li>
    </ul>

</article>
</main>
<?php
include '../footer.php';
?>