<?php
session_start();
include('../classes/database.php');
include('../classes/validator.php');
include('../classes/user.php');
include('../classes/article.php');
include('../classes/category.php');
include('../classes/post.php');
include('../classes/comment.php');
include '../utils/auth_check.php';

$user = new User();
$isAdmin = $user->isAdmin();
if (!$isAdmin) {
	header("Location: /");
	die();
}
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="/styles.css" />
	<link rel="stylesheet" href="/style_overrides.css" />
	<link rel="stylesheet" href="/style_addons.css" />
	<title>Admin - Northampton News</title>
</head>

<body>
	<header>
		<section>
			<h1>Northampton News</h1>
		</section>
	</header>
	<nav>
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/?sort-by=1">Latest Articles</a></li>
			<li><a href="#">Select Category</a>
				<ul>
					<br>
					<!-- Get list of categories from database -->
					<?php
					// New category object
					$categoryObj = new Category();
					$categories = array();

					// retrieve array of category objects
					$categories = $categoryObj->getListOfCategories();

					foreach ($categories as $category) {
						// Display as list one by one
						echo '<li><a href="?category=' . $category->category_id . '">' . ($category->getName()) . '</a></li>';
					}
					?>
				</ul>
			</li>
			<li><a href="contact.php">Contact us</a></li>
		</ul>
	</nav>

	<br>

	<main>
		<nav>
			<h3>News Article</h3>
			<ul>
				<li><a href="create-story.php">Add New Story</a></li>
				<li><a href="posts.php">All Posts</a></li>
			</ul>

			<h3>Category</h3>
			<ul>
				<li><a href="categories.php">Manage Categories</a></li>
			</ul>

			<h3>Comments</h3>
			<ul>
				<li><a href="comments-recent.php">Recent Comments</a></li>
				<li><a href="comments-moderation.php">Pending Moderation</a></li>
			</ul>

			<h3>Users</h3>
			<ul>
				<li><a href="account-users.php">View All</a></li>
				<li><a href="account-admins.php">Admins</a></li>
			</ul>
		</nav>