<?php
	include ('../classes/database.php');
	include ('../classes/user.php');
	include ('../classes/article.php');
	include ('../classes/category.php');
	include ('../classes/comment.php');
	include ('../classes/share.php');
    include ('../utils/auth_check.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="/fontawesome/css/all.css">
		<link rel="stylesheet" href="/styles.css"/>
		<link rel="stylesheet" href="/style_overrides.css">
		<link rel="stylesheet" href="/style_addons.css">
		<title>Northampton News - Article</title>
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
		<img src="/images/banners/randombanner.php" />