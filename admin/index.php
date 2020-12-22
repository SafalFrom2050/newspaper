<?php
    session_start();
    include '../functions/checks.php';
    include '../utils/auth_check.php';

    $isAdmin =isCurrentUserAdmin();
    if(!$isAdmin){
        header("Location: /");
        die();
    }

    include 'header.php';
?>
<br>
<div class="admin">
        <div class="left">
            <a href="#"> TESTING </a>
        </div>
        <div class="left">
            <a href="#"> TESTING </a>
        </div>
        <div class="right">
        <a href="#"> TESTING </a>
        </div>

    </div>
<main>
    <nav>
		<ul>
            <li><a href="#">News Articles</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="#">Comments Moderation</a></li>
		</ul>
	</nav>
    <article>
    	<h2>Welcome To Admin Section</h2>
		<p>Options:</p>
    </article>
    
</main>


<?php
    include 'footer.php';
?>