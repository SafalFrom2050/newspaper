<?php
    session_start();
    include '../header.php';

    if(User::isLoggedIn()){
        header("Location: /");
        die();
    }
?>

<main>
    <div class="login-form">
        <h2>Login</h2>
        <form method="POST" action='logincheck.php'>

            <label for="username">Username</label>
            <input type="username" name="username">

            <label for="password">Password</label>
            <input type="password" name="password">

            <input type="submit" value="Login">
        </form>
    </div>
    <br><br>
    <div class="signup-form">
        <h2>No Account?</h2>
        <a href="signup.php"><button class="button-padding">Create Account</button></a>
    </div>

</main>
<?php
    include '../footer.php';
?>