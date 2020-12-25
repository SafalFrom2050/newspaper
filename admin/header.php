<?php
	//TODO
    session_start();
	include ('../classes/database.php');
	include ('../classes/user.php');
	include ('../classes/article.php');
	include ('../classes/category.php');
    include '../utils/auth_check.php';

	$user = new User();
    $isAdmin = $user->isAdmin();
    if(!$isAdmin){
        header("Location: /");
        die();
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/styles.css"/>
		<link rel="stylesheet" href="/style_overrides.css"/>
		<title>Northampton News - Home</title>
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
				<li><a href="#">Latest Articles</a></li>
				<li><a href="#">Select Category</a>
					<ul>
					<br>
						<?php
							$categoryObj = new Category();
							$categories = array();
							$categories = $categoryObj->getListOfCategories();

							foreach($categories as $category){
								echo '<li><a href="?navigate='.$category->category_id.'">'.($category->getName()).'</a></li>';
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
				<li><a href="#">Edit Categories</a></li>
			</ul>

			<h3>Comments</h3>
			<ul>
				<li><a href="#">Recent Comments</a></li>
				<li><a href="#">Pending Moderation</a></li>
			</ul>
		</nav>