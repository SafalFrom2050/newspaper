<?php
session_start();
include 'header.php';
?>

<main>

    <div class="home">

        <div class="account-details">
            <!-- Current user database information -->
            <?php
            // create user object of current user
            $user = User::current();

            // create a new validator object
            $validator = new Validator();

            // Check if 'name' is posted 
            if (isset($_POST['name'])) {
                // Validate name
                $verifyName = $validator->verifyName($_POST['name']);
                // Check for errors
                if ($verifyName === true) {
                    // No errors, change the name in database
                    $name = $_POST['name'];
                    $user->updateUserDisplayName($name);
                    echo '<h3 class="success-msg">Your name has been changed!</h3>';
                } else {
                    // Error! do not change
                    echo '<h3 class="error-msg">' . $verifyName . '</h3>';
                }
                // check if username is posted
            } else if (isset($_POST['username'])) {
                // validate username
                $verifyUsername = $validator->verifyUsername($_POST['username']);

                // check for errors
                if ($verifyUsername === true) {
                    // No errors! can change in database
                    $username = $_POST['username'];
                    $user->updateUserUserName($username);
                    echo '<h3 class="success-msg">Your username has been changed!</h3>';
                } else {
                    // error! should not change in database
                    echo '<h3 class="error-msg">' . $verifyUsername . '</h3>';
                }

                // check if email is posted
            } else if (isset($_POST['email'])) {
                // validate email
                $verifyEmail = $validator->verifyEmail($_POST['email']);

                // check for errors
                if ($verifyEmail === true) {
                    // no errors! can change in database
                    $email = $_POST['email'];
                    $user->updateUserEmail($email);
                    echo '<h3 class="success-msg">Your email has been changed!</h3>';
                } else {
                    // contains errors, should not change
                    echo '<h3 class="error-msg">' . $verifyEmail . '</h3>';
                }
                // check if current password, new password and retry password has been posted
            } else if (isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['retry-password'])) {
                $current_password = $_POST['current-password'];
                $new_password = $_POST['new-password'];
                $retry_password =  $_POST['retry-password'];

                // validate inputs
                $verifyPassword = $validator->verifyPasswordUpdate($current_password, $new_password, $retry_password);

                // check for errors
                if ($verifyPassword === true) {
                    // no errors! can change in database
                    $user->updateUserPassword($new_password);
                    echo '<h3 class="success-msg">Your password has been changed!</h3>';
                } else {
                    // error! should warn the user
                    echo '<h3 class="error-msg">' . $verifyPassword . '</h3>';
                }
            }

            ?>


            <!-- Show account details -->
            <h2>Account Details</h2>
            <div class="info">
                <ul>
                    <li>
                        <div class="left">Name</div>
                        <div class="right">

                            <?php
                            // create User object of current user
                            $user = User::current();

                            // check if name is in GET parameters
                            if (isset($_GET['name'])) {
                                // if yes, show input box instead of name label
                                echo '
                                    <form method="POST">
                                        <input type="text" name="name" value="' . $user->name . '" placeholder="Name...">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                            } else {
                                // else show name label
                                echo $user->name;
                                echo '
                                        <a href="?name=1">Edit</a>
                                    ';
                            }
                            ?>
                        </div>
                    </li>
                    <li>
                        <div class="left">Username</div>
                        <div class="right">

                            <?php
                            // check if username is in GET parameters
                            if (isset($_GET['username'])) {
                                // should edit if yes
                                echo '
                                    <form method="POST">
                                        <input type="text" name="username" value="' . $user->username . '" placeholder="@username...">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                            } else {
                                // should show label only if no
                                echo $user->username;
                                echo '
                                        <a href="?username=1">Edit</a>
                                    ';
                            }
                            ?>
                        </div>
                    </li>
                    <li>
                        <div class="left">Email</div>
                        <div class="right">

                            <?php

                            // check if email is in GET parameters
                            if (isset($_GET['email'])) {
                                // if yes, show edit input box
                                echo '
                                    <form method="POST">
                                        <input type="text" name="email" value="' . $user->email . '" placeholder="New Email...">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                            } else {
                                // else show label only
                                echo $user->email;
                                echo '
                                        <a href="?email=1">Edit</a>
                                    ';
                            }
                            ?>
                        </div>
                    </li>
                    <li>
                        <div class="left">Password</div>
                        <div class="right">
                            <?php
                            // check if password is in GET parameters
                            if (isset($_GET['password'])) {
                                // if yes, show edit input box 
                                echo '
                                    <form method="POST" class="password-change">
                                        <input type="password" name="current-password" placeholder="Current Password">
                                        <input type="password" name="new-password" placeholder="New Password">
                                        <input type="password" name="retry-password" placeholder="Type Again">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                            } else {
                                // if no, show edit password button and label only
                                echo '
                                        <a href="?password=1">Edit</a>
                                    ';
                            }
                            ?>

                        </div>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</main>

<?php
include '../footer.php';
?>