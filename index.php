<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        if($_SESSION['is_user']){
            header('Location: user/');
        }
        else if($_SESSION['is_super_user']){
            header('Location: super_user/');
        }
    }
    include('connection.php');
    $mssg = '';
    if(isset($_GET['mssg'])){
        $mssg = $_GET['mssg'];
    }
    $error = $email = '';
    if (isset($_POST['submit'])){
        $email = htmlspecialchars($_POST['email']);
        $user_role = $_POST['myrole'];
        $passcode = htmlspecialchars($_POST['password']);

        $user_sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";

        $result = mysqli_query($conn, $user_sql);
        $user = mysqli_fetch_assoc($result);

        if(array_filter($user)){   
            if(password_verify($passcode, $user['passcode'])){
                $user_id = (int)$user['user_id'];
                $role_sql = "SELECT * FROM user_role WHERE user_id = $user_id";
                $roles = mysqli_query($conn, $role_sql);
                $myrole = mysqli_fetch_all($roles,   MYSQLI_ASSOC);
                
                if($user_role == "user"){
                    if($myrole[0]['is_user']){
                        session_start();
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['user_name'] = $user[0]['user_name'];
                        $_SESSION['is_user'] = true;
                        header('Location: user/');
                        exit();
                    }
                    else{
                        $error = "incorrect email or password";
                    }
                }

                else if($user_role == "super_user"){
                    if($myrole[0]['is_super_user']){
                        session_start();
                        $_SESSION['user_id'] = $user_id;
                        $_SESSION['user_name'] = $user[0]['user_name'];
                        $_SESSION['is_super_user'] = true;
                        header('Location: super_user/');
                        exit();
                    }
                    else{
                        $error = "incorrect email or password";
                    }
                }
            } 
            else{
                $error = "incorrect email or password";
            }  
            
        }

        else{
            $error = "incorrect email or password";
        }
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>master entertainer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/loginStyle.css">
        <link rel="stylesheet" href="css/footerStyle.css">
    </head>
    <body>
        <div class="nav">
            <h3>master entertainer</h3>
        </div>
            
        <div class="welcm">
            <div class="wlmessg">
                <p>welcome to master entertainer.
                    join and enjoy different entertainment stuff like 
                    artist shows, football matches, movies and other many things.</p>
            </div>
            <div class="loginForm">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                    <fieldset>
                        <div class="eCont">
                            <?php if($mssg):?>
                                <div class="mssg"><p><?php echo $mssg ?></p></div>
                            <?php endif; ?>
                            <?php if($error):?>
                            <div class="error"><p><?php echo $error ?></p></div>
                            <?php endif; ?>
                            
                            <label for="email">email: </label><br>
                            <input type="email" name="email" required autofocus value="<?php echo $email ?>"><br>
                            <label for="password">password: </label><br>
                            <input type="password" name="password" required autocomplete="off"><br>

                            <input type="radio" name="myrole" value="user" checked>
                            <label for="role">user</label><br>
                            <input type="radio" name="myrole" value="super_user">
                            <label for="role">super-user</label><br>

                            <input type="submit" name="submit" value="login">
                            <div class="reg">
                                <p>do not have account? <a href="signup.php">register</a></p>
                            
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
        
        <?php include('footer.php') ?>
    </body>                            
</html>