<?php
    session_start();
    include 'functions/checks.php';
    include 'utils/auth_check.php';
    include 'header.php';
?>

<main>
	<nav>
		<ul>
            <?php
                 $isAdmin =isCurrentUserAdmin();
                 if($isAdmin){
                     echo '<li><a href="/admin">Admin Panel</a></li>';
                 }
            ?>
			
		</ul>
	</nav>
    <article>
    	<h2>Home</h2>
		<p>Featured articles</p>
	</article>
</main>


<?php
    include 'footer.php';
?>