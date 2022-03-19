<?php
    require_once('../Controllers/UserController.php');
    $user = new UserController();

    //get data
    $result = mysqli_query(mysqli_connect('localhost', 'root', '', 'mini_project'), "select * from users");
    $data = [];
    while($row = mysqli_fetch_array($result, 1)){
        $data[] = $row;
    }
    mysqli_close(mysqli_connect('localhost', 'root', '', 'mini_project'));
    

    if(!$user->is_login()){
        header('Location: ../');
        die();
    }

    //check logout
    if(isset($_POST['logout'])){
        $user->logout();
    }
    
    if(isset($_POST['action'])){
        $id = $_POST['id'];
        $user->delete($id);
    }

    if(isset($_GET['edit'])){
        $user->show_edit($_GET['id']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="../aseet/script.js"></script>
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
                <h2 class="text-center">Danh sách tài khoản</h2>
            </div>
            <div class="panel-body">
                <br></br>
                <input id="myInput" type="text" placeholder="Nhập từ khóa bạn cần tìm" style="width:20%; margin-bottom:15px" />
                <table class="table table-bordered table-hover" id="myTable">
                    <thead>
                        <tr>
                            <th width="50px">STT</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th width="80px">Sửa</th>
                            <th width="80px">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $index = 1;
                        foreach ($data as $item) {
                            echo '
                                <tr>
                                    <td>' . $index++ . '</td>
                                    <td>' . $item['FullName'] . '</td>
                                    <td>' . $item['Email'] . '</td>
                                    <td>' . $item['PassWords'] . '</td>
                                    <td>
                                        <form method="get" action="">
                                            <input type="text" name="id" value="' . $item['UserID'] . '" style="display: none;">
                                            <input type="submit" class="btn btn-warning" name="edit" value="edit">
                                        </form>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" onclick="myInput(' . $item['UserID'] . ');">delete</button>   
                                    </td>
                                </tr>
                                ';
                        }
                        ?>
                    </tbody>
                </table>
                <ul class="pagination">
                </ul>
            </div>
        </div>
    </div>
</body>

</html>