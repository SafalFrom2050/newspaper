<?php
    include ('functions/read.php');
	include ('classes/category.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="styles.css"/>
		<link rel="stylesheet" href="style_overrides.css">
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
							$categories = array();
							$categories = getListOfCategories();

							foreach($categories as $category){
								echo '<li><a href="?navigate='.$category->category_id.'">'.($category->getName()).'</a></li>';
							}
						?>
					</ul>
				</li>
				<li><a href="contact.php">Contact us</a></li>
			</ul>
		</nav>
		<img src="images/banners/randombanner.php" />