

<?php
session_start();
?>


<form method="POST" action='logincheck.php'>

<label for="username">Username</label>
<input type="username" name="username">

<label for="password">Password</label>
<input type="password" name="password">

<input type="submit" value="Login">

</form>