<?php
require_once('../Controllers/UserController.php');
$user = new UserController();
if (isset($_POST['edit'])) {
    if($_POST['name'] != ''){
        $user->edit($_POST['id'], $_POST['name'], $_POST['email'], $_POST['pwd']);
    }
    else{
        $_SESSION['susses_edit'] = "Tên không được để trống";
    }
}

if (isset($_POST['logout'])) {
    $user->logout();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Sửa Tài Khoản</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        .logout {
            position: absolute;
            top: 16px;
            right: 16px;
        }
    </style>
</head>

<body>
    <div class="logout">
        <form action="" method="post">
            <input type="submit" name="logout" value="logout">
        </form>
    </div>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Sửa Tài Khoản</h2>
            </div>
            <div class="panel-body">
                <?php
                    if(isset($_SESSION['susses_edit'])){
                        echo '<p style="text-align: center; color: green;">'.$_SESSION['susses_edit'].'<p>';
                    }
                    if(isset($_SESSION['errors_edit'])){
                        echo '<p style="text-align: center; color: red;">'.$_SESSION['errors_edit'].'<p>';
                    }
                    $item = $_SESSION['data_editor'];
                    echo '
                        <form method="POST" >
                            <div class="form-group">
                                <label for="Ten">Tên:</label>
                                <input type="text" name="id" value="' . $item['UserID'] . '" hidden="true">
                                <input type="text" class="form-control" id="name" name="name" value="' . $item['FullName'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="' . $item['Email'] . '" required>
                            </div>
                            <div class="form-group">
                                <label for="IDuser">Password:</label>
                                <input type="password" class="form-control" id="pwd" name="pwd" value="" >
                            </div>
                            <input type="submit" class="btn btn-success" name="edit" value="lưu">
                        </form>
                    ';

                ?>
            </div>
        </div>
    </div>
</body>

</html>