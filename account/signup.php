<?php
session_start();
include '../header.php';

// before loading anything else, check if the user is already logged in
if (User::isLoggedIn()) {
    header("Location: /");
    die();
}
?>

<main>
    <div class="signup-form">
        <?php
        // Signup form template
        $signup_template = '
            
                <h2>Signup</h2>
                <form method="POST">

                <label for="firstname">First Name</label>
                <input type="name" name="firstname">

                <label for="lastname">Last Name</label>
                <input type="name" name="lastname">

                <label for="username">Username</label>
                <input type="username" name="username">

                <label for="email">Email</label>
                <input type="email" name="email">

                <label for="email_notification">Notify Via Email For New Article</label>
                <input type="checkbox" style="margin-top:2rem;" name="email_notification"/>

                <input type="submit" value="Signup">
                </form>
    ';

        // check if the form is filled
        if (
            isset($_POST['firstname']) && isset($_POST['lastname']) &&
            isset($_POST['username']) && isset($_POST['email'])
        ) {


            // Removing whitespaces before start and end of string
            $firstname = trim($_POST['firstname']);
            $lastname = trim($_POST['lastname']);

            // Storing username and emails in all-lowercase
            $email = strtolower(trim($_POST['email']));
            $username = strtolower(trim($_POST['username']));

            $name = $firstname . ' ' . $lastname;

            // variable to hold any errors
            $error = false;

            // Validate form inputs
            $verify_firstname = verifyName($firstname);
            if ($verify_firstname !== true) {
                echo createMsg($verify_firstname);
                // set error to true
                $error = true;
            }

            $verify_lastname = verifyName($lastname);
            if ($verify_lastname !== true && !$error) {
                echo createMsg($verify_lastname);
                // set error to true
                $error = true;
            }

            $verify_username = verifyUsername($username);
            if ($verify_username !== true && !$error) {
                echo createMsg($verify_username);
                // set error to true
                $error = true;
            }

            $verify_email = verifyEmail($email);
            if ($verify_email !== true && !$error) {
                echo createMsg($verify_email);
                // set error to true
                $error = true;
            }

            // Create new User object
            $user = new User();

            if (!$error) {
                // Duplicate Email and Username Validation
                if (!$user->getUserFromEmail($email)) {
                    // everything is fine, can signup
                    $generated_password = $user->signUp($username, $name, $email);
                    echo createSuccessMsg('Account created!<br><br>Please login with your username and this randomly created password: <u>' . $generated_password . '</u>');
                } else {
                    // Email already exists in the database
                    echo createMsg('Email already exists!');
                }
            }
        } else {
            // if the form is not submitted, display form
            echo $signup_template;
        }



        // Functions to validate form components


        function verifyName($name)
        {
            $name = trim($name);

            // check is the word is of less than 2 characters
            if (strlen($name) < 2) {
                return 'First name or last name cannot be less than 2 characters!';
            }
            // everything is fine
            return true;
        }

        function verifyUsername($username)
        {
            // validate using constaints set for name first
            if (verifyName($username) !== true) {
                return 'Username Invalid!';
            }

            $user = new User();

            // check is username already exists in the database
            if ($user->doesUsernameExist($username)) {
                return 'Username already exists';
            }
            return true;
        }

        function verifyEmail($email)
        {
            // check is the email is in xxx@xxxx.com format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return 'Invalid Email!';
            }

            return true;
        }

        // function to create error message box with 'Try again' link
        function createMsg($msg)
        {
            $part_1 = $msg;
            $part_2 = '<br><a href="signup.php">Try Again</a>';

            return $part_1 . $part_2;
        }

        // function to create success message
        function createSuccessMsg($msg)
        {
            $part_1 = $msg;
            $part_2 = '<br><br><br> <b>Please Note:</b> 
                We cannot guarantee 100% security for the data you provide at the moment because 
                this website is still in its early development phase.
                <br> Make sure you change your password as soon as you login.';
            return $part_1 . $part_2;
        }

        ?>
    </div>

    <!-- This is to link the signup page with login page -->
    <div class="login-form">
        <?php
        // if any error variable is set and is not true (meaning no errors during signup)
        if (isset($error) && !$error) {
            echo '<h2>Start by loggin in...</h2>';
        } else {
            echo '<h2>Already have an account?</h2>';
        }
        ?>

        <a href="login.php"><button class="button-padding">Login</button></a>

    </div>
</main>
<?php
include '../footer.php';
?>