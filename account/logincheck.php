<!-- 
    This Page is used for processing login credentials when user logs in
 -->

<?php
session_start();
include '../header.php';
?>
<main>
    <div class="center-text" style="margin-top:3rem;">
        <?php
        // Create a new user object
        $user = new User();

        // Check if the username is available in POST
        if (isset($_POST['username'])) {
            // Use function of User class to verify login which returns a user if valid else returns null
            $user = $user->verifyUserCredentials($_POST['username'], $_POST['password']);

            // Check is the user is not null 
            if (!is_null($user)) {
                // Logged In!
                $_SESSION['logged_in'] = true;
                $_SESSION['user_id'] = $user->user_id;

                echo '<h1>Redirecting to the homepage</h1>';

                // Now redirect to homepage
                header("Location: /");
                die();
            } else {
                // Something is wrong, probably the login credentials 
                echo '<h2>Check your email/password...</h2>';
                echo '<h2><a href=login.php>Try Again</a><h2>';
            }
        }
        ?>
    </div>
</main>
<?php
include '../footer.php';
?>