<?php
include('../classes/database.php');
include('../classes/user.php');
include('../classes/article.php');
include('../classes/category.php');
include('../classes/comment.php');
include('../classes/comment_reply.php');
include('../classes/share.php');
?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="/fontawesome/css/all.css">
	<link rel="stylesheet" href="/styles.css" />
	<link rel="stylesheet" href="/style_overrides.css">
	<link rel="stylesheet" href="/style_addons.css">
	<title>Article - Northampton News</title>
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
						echo '<li><a href="/?category=' . $category->category_id . '">' . ($category->getName()) . '</a></li>';
					}
					?>
				</ul>
			</li>
			<li><a href="contact.php">Contact us</a></li>
		</ul>
	</nav>
	<img src="/images/banners/randombanner.php" />