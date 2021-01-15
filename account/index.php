<?php
    session_start();
    include 'header.php';
?>

<main>
    
    <div class="home">
        
        <div class="account-details">

            <?php
                $user = User::current();
                $validator = new Validator();

                if(isset($_POST['name'])){
                    $verifyName = $validator->verifyName($_POST['name']);
                    if($verifyName===true){
                        $name = $_POST['name'];  
                        $user->updateUserDisplayName($name);
                        echo '<h3 class="success-msg">Your name has been changed!</h3>';
                    }else{
                        echo '<h3 class="error-msg">'.$verifyName.'</h3>';
                    }
                    
                }else if(isset($_POST['username'])){
                    $verifyUsername = $validator->verifyUsername($_POST['username']);
                    if($verifyUsername===true){
                        $username = $_POST['username'];
                        $user->updateUserUserName($username);
                        echo '<h3 class="success-msg">Your username has been changed!</h3>';
                    }else{
                        echo '<h3 class="error-msg">'.$verifyUsername.'</h3>';
                    }
                    
                }else if(isset($_POST['email'])){
                    $verifyEmail = $validator->verifyEmail($_POST['email']);
                    if($verifyEmail===true){
                        $email = $_POST['email'];
                        $user->updateUserEmail($email);
                        echo '<h3 class="success-msg">Your email has been changed!</h3>';
                    }else{
                        echo '<h3 class="error-msg">'.$verifyEmail.'</h3>';
                    }
                }else if(isset($_POST['current-password']) && isset($_POST['new-password']) && isset($_POST['retry-password'])){
                    $current_password = $_POST['current-password'];
                    $new_password = $_POST['new-password'];
                    $retry_password =  $_POST['retry-password'];
                    $verifyPassword = $validator->verifyPasswordUpdate($current_password, $new_password, $retry_password);

                    if($verifyPassword===true){
                        $user->updateUserPassword($new_password);
                        echo '<h3 class="success-msg">Your password has been changed!</h3>';
                    }else{
                        echo '<h3 class="error-msg">'.$verifyPassword.'</h3>';
                    }
                }

            ?>

            <h2>Account Details</h2>
            <div class="info">
                <ul>
                    <li>
                        <div class="left">Name</div>
                        <div class="right">
                            
                            <?php
                                $user = User::current();
                                
                                if(isset($_GET['name'])){
                                    echo '
                                    <form method="POST">
                                        <input type="text" name="name" value="'.$user->name.'" placeholder="Name...">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                                }else{
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
                                
                                if(isset($_GET['username'])){
                                    echo '
                                    <form method="POST">
                                        <input type="text" name="username" value="'.$user->username.'" placeholder="@username...">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                                }else{
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
                                
                                if(isset($_GET['email'])){
                                    echo '
                                    <form method="POST">
                                        <input type="text" name="email" value="'.$user->email.'" placeholder="New Email...">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                                }else{
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
                                
                                if(isset($_GET['password'])){
                                    echo '
                                    <form method="POST" class="password-change">
                                        <input type="password" name="current-password" placeholder="Current Password">
                                        <input type="password" name="new-password" placeholder="New Password">
                                        <input type="password" name="retry-password" placeholder="Type Again">
                                        <input type="submit" value="Change">
                                    </form>
                                    ';
                                }else{
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