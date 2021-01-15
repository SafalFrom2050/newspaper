<?php
include 'header.php';
?>
<article>
    <?php

    if (isset($_POST['delete'])) {
        $userObj = User::withID($_POST['user_id']);

        $userObj->delete();
        echo '<h3 class="success-text">Admin Removed!</h3><br><br>';
    }

    if (isset($_POST['make_admin'])) {
        $userObj = User::withID($_POST['user_id']);

        $setAdmin = !$_POST['user_is_admin'];
        $userObj->setAdmin($setAdmin);

        echo '<h3 class="success-text">Admin Status Changed!</h3><br><br>';
    }

    if (isset($_POST['create_new_admin'])) {

        $validator = new Validator();

        $username = $_POST['username'];
        $password = $_POST['password'];
        $name = $_POST['name'];
        $email = $_POST['email'];

        $error = false;

        // Validate Name
        $validate = $validator->verifyName($name);
        if ($validate !== true) {
            $error = true;
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Validate Username
        $validate = $validator->verifyUsername($username);
        if ($validate !== true) {
            $error = true;
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Validate Email
        $validate = $validator->verifyEmail($email);
        if ($validate !== true) {
            $error = true;
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // Validate Password
        $validate = $validator->verifyPassword($password);
        if ($validate !== true) {
            $error = true;
            echo '<h3 class="error-text">' . $validate . '</h3><br><br>';
        }

        // No errors
        if (!$error) {
            $userObj = new User();
            $userObj->createAdmin($username, $password, $email, $name);
            echo '<h3 class="success-text">New Admin Created!</h3><br><br>';
        }
    }

    ?>
    <h2>
        <a href="/admin">Back</a>
        Manage Admins
    </h2>

    <div class="users-list no-border">
        <?php
        $userObj = new User();
        $users = array();
        $users = $userObj->getAllAdminsList();

        foreach ($users as $user) {
            echo '<div class="accounts-list-item">';

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