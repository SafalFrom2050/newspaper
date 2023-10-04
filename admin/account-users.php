<?php
include 'header.php';
?>
<article>
    <?php

    // check if delete is set
    if (isset($_POST['delete'])) {
        $userObj = User::withID($_POST['user_id']);

        // delete user
        $userObj->delete();

        // Show success message
        echo '<h3 class="success-text">Admin Removed!</h3><br><br>';
    }

    // check if make_admin is set
    if (isset($_POST['make_admin'])) {
        $userObj = User::withID($_POST['user_id']);

        // Set Admin if not admin, else remove from admin
        $setAdmin = !$_POST['user_is_admin'];
        $userObj->setAdmin($setAdmin);

        // Show success message
        echo '<h3 class="success-text">Admin Status Changed!</h3><br><br>';
    }

    ?>

    <!-- Title with back button -->
    <h2>
        <a href="/admin">Back</a>
        Manage All Users
    </h2>

    <!-- List of all users -->
    <div class="users-list no-border">
        <?php
        $userObj = new User();
        $users = array();

        // Get list of all users
        $users = $userObj->getAllUsersList();

        // Loop through all of them
        foreach ($users as $user) {

            // show each user with option to add or remove admin, view profile or delete
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
</article>
</main>
<?php
include '../footer.php';
?>