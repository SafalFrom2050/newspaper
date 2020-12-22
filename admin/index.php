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

<main>
    <article>
    	<h2>Welcome To Admin Section</h2>
		<p>Options:</p>
	</article>
</main>


<?php
    include 'footer.php';
?>