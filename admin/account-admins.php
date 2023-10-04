<?php
include 'header.php';
?>
<article>
    <?php

    // check is delete input is set
    if (isset($_POST['delete'])) {
        // create User object with user_id provided by POST
        $userObj = User::withID($_POST['user_id']);

        // Delete the user
        $userObj->delete();

        // Show success text
        echo '<h3 class="success-text">Admin Removed!</h3><br><br>';
    }

    // Check is make_admin is set
    if (isset($_POST['make_admin'])) {
        // create User object with user_id provided by POST
        $userObj = User::withID($_POST['user_id']);

        // variable to hold if to set the user as admin or remove from admin
        $setAdmin = !$_POST['user_is_admin'];

        // Set user previledge as $setAdmin
        $userObj->setAdmin($setAdmin);

        // Show success text
        echo '<h3 class="success-text">Admin Status Changed!</h3><br><br>';
    }

    // check if creaet_new_admin is set
    if (isset($_POST['create_new_admin'])) {

        // create new Validator object
        $validator = new Validator();

        // create variables with parameters provided by POST
        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        // Variable to hold error
        $error = false;

        // Validate Name
        $validate = $validator->verifyName($name);
        if ($validate !== true) {
            // set error to true
            $error = true;

            // show error message
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Validate Username
        $validate = $validator->verifyUsername($username);
        if ($validate !== true) {
            // set error to true
            $error = true;

            // show error message
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Validate Email
        $validate = $validator->verifyEmail($email);
        if ($validate !== true) {
            $error = true;
            // show error message
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Validate Password
        $validate = $validator->verifyPassword($password);
        if ($validate !== true) {
            $error = true;
            // show error message
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Check for errors
        if (!$error) {
            // Can create admin account
            $userObj = new User();
            $userObj->createAdmin($username, $password, $email, $name);

            // show success message
            echo '<h3 class="success-text">New Admin Created!</h3><br><br>';
        }
    }

    ?>
    <!-- Title and back button -->
    <h2>
        <a href="/admin">Back</a>
        Manage Admins
    </h2>

    <div class="users-list no-border">
        <?php
        // create user object
        $userObj = new User();

        // get list of all admins
        $users = array();
        $users = $userObj->getAllAdminsList();

        // Loop through all admins
        foreach ($users as $user) {

            // display name, email and option to add/remove from admin, view profile
            echo '<div class="accounts-list-item">';

            // Check if user is admin or not to set options accordingly
            $adminOpt = $user->is_admin ? 'Remove Admin' : 'Add Admin';

            echo '<h3>' . $user->name .
                '
                    <form method="POST" onsubmit="return confirm(`Confirm?`);">

                        <input type="hidden" name="user_id" value="' . $user->user_id . '" />
                        <input type="hidden" name="user_is_admin" value="' . $user->is_admin . '" />
                        <input type="submit" name="delete" value="Delete" />
                    
                        <input type="submit" name="make_admin" value="' . $adminOpt . '" />
                    </form>
                    <a href="/user?id=' . $user->user_id . '">View Profile</a>
                    </h3>';
            echo '<br>' . $user->email;
            echo '</div>';
        }
        ?>
    </div>

    <!-- Html form to create new admin -->
    <h3>Create New Admin</h3>
    <form method="POST" class="add-admin">
        <label for="name">Name:</label>
        <input type="name" name="name" placeholder="Name...">
        <label for="email">Email:</label>
        <input type="email" name="email" placeholder="Email...">
        <label for="username">Username:</label>
        <input type="text" name="username" placeholder="Username...">
        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Password...">
        <input type="submit" name="create_new_admin" value="Create Admin">
    </form>
</article>
</main>
<?php
include '../footer.php';
?>