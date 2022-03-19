<?php
require_once('../Controllers/UserController.php');
$user = new UserController();

if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $comfirm = $_POST['comfirmpass'];

    if (strlen($pass) < 6) {
        $_SESSION['errors'] = "mật khẩu quá ngắn!";
    } else {
        if($name != ''){
            $user->create($name, $email, $pass, $comfirm);
        }
        else{
            $_SESSION['errors_sign'] = "tên không được để trống!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>create account because you not account</title>
    <link rel="stylesheet" href="../aseet/style.css">
</head>

<body>
    <div class="center">
        <h1>Đăng ký</h1>
        <form method="post" action="">
            <div class="message">
                <?php
                if (isset($_SESSION['errors_sign'])) {
                    echo '<p style="color: red; text-align: center;">' . $_SESSION['errors_sign'] . '</p>';
                } else {
                    if (isset($_SESSION['susses_sign'])) {
                        echo '<p style="color: green; text-align: center;">' . $_SESSION['susses_sign'] . '</p>';
                    }
                }
                ?>
            </div>
            <div class="txt_field">
                <input type="text" name="name" required>
                <span></span>
                <label>Full Name</label>
            </div>
            <div class="txt_field">
                <input type="email" name="email" required>
                <span></span>
                <label>Email</label>
            </div>
            <div class="txt_field">
                <input type="password" name="password" minlength="6" required>
                <span></span>
                <label>Password</label>
            </div>
            <div class="txt_field">
                <input type="password" name="comfirmpass" required>
                <span></span>
                <label>Confirm password</label>
            </div>
            <input type="submit" name="create" value="Đăng ký">
            <div class="signup_link">
                <a href="../">you have a account?</a>
            </div>
        </form>
    </div>
</body>

</html>