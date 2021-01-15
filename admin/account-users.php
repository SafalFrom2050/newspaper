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

    ?>

    <h2>
        <a href="/admin">Back</a>
        Manage All Users
    </h2>

    <div class="users-list no-border">
        <?php
        $userObj = new User();
        $users = array();
        $users = $userObj->getAllUsersList();

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
</article>
</main>
<?php
include '../footer.php';
?>