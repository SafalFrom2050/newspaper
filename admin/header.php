<?php
	//TODO
    session_start();
    include '../functions/checks.php';
    include '../functions/write.php';

    include '../utils/auth_check.php';

    $isAdmin =isCurrentUserAdmin();
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