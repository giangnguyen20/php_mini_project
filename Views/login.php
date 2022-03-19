<?php
    require_once('../Controllers/UserController.php');

    $user = new UserController();

    if($user->is_login()){
        header('Location: ../Views/home.php');
        die();
    }

    if(isset($_POST['login'])){
        if(strlen($_POST['password']) < 6){
            $_SESSION['errors'] = "mật khẩu quá ngắn!";
        }
        else{           
            $remember = isset($_POST['remember']) ? $_POST['remember'] : '';
            $user->login($_POST['email'], $_POST['password'], $remember);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login because you not login</title>
    <link rel="stylesheet" href="../aseet/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="center">
        <h1>Login</h1>
        <form method="post" action="">
            <div class="message">
                <p id="smg" style="display: none;"></p>
                <?php
                    if (isset($_SESSION['errors_login'])) {
                        echo '<p style="color: red; text-align: center;">' . $_SESSION['errors_login'] . '</p>';
                    }
                ?>
            </div>
            <div class="txt_field">
                <input type="email" name="email" id="email" value="<?php
                    if(isset($_COOKIE['email'])){
                        echo $_COOKIE['email'];
                    }
                ?>" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" id="password" minlength="6" value="<?php 
                    if(isset($_COOKIE['password'])){
                        echo $_COOKIE['password'];
                    }
                ?>" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="pass">
                <input type="checkbox" name="remember"> Remember me
            </div>
            <input type="submit" name="login" value="Login">
            <div class="signup_link">
                Not a member? <a href="register.php">Signup</a>
            </div>
        </form>
    </div>
</body>

</html>