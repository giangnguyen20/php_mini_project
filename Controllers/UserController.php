<?php
// use function CommonMark\Render;
require_once('Controller.php');
session_start();
class UserController extends Controller{

    public $db;
    private $key_md5 = "ndashklaaksna1@#$@!$";

    public function __construct()
    {
        parent::loadModel('DB_User');
        $this->db = new DB_User();
    }

    public function login($email, $pwd, $remember)
    {
        $pass = md5(md5($pwd).$this->key_md5);

        $sql = "select * from users where Email = '$email' and PassWords = '$pass'";
        //check email
        switch ($this->check_email($email)){
            case true:
                $result = $this->db->select_row($sql);
                if($result != null){
                    if($remember != ''){
                        setcookie("email", $email, time() + 3600 * 24 * 10);
                        setcookie("password", $pwd, time() + 3600 * 24 * 10);
                    }
                    setcookie('islogin', 1, time() + 900);
                    // $_SESSION['name'] = $result['FullName'];
                    session_destroy();
                    header('Location: home.php');
                    exit();
                }
                else{
                    $_SESSION['errors_login'] = "Email hoặc mật khẩu không đúng!";
                    header('Location: login.php');
                }
                break;
            case false:
                $_SESSION['errors_login'] = "Email không đúng định dạng!";
                header('Location: login.php');
                break;
        }

    }

    public function create($name ,$email, $pwd, $comfirm_pwd){
        $sql = "SELECT * FROM users WHERE Email = '$email'";

        switch ($this->check_email($email)){
            case true:
                if($pwd == $comfirm_pwd && strlen($pwd) >= 6){
                    $pwd = md5(md5($pwd).$this->key_md5);
                    
                    if($this->db->select_row($sql) != null){
                        $_SESSION['errors_sign'] = "Email đã tồn tại!";
                    }
                    else{
                        $sql = "INSERT INTO users VALUES(null, '$name', '$email', '$pwd', current_timestamp())";
                        $this->db->add_new($sql);
                        unset($_SESSION['errors_sign']);
                        $_SESSION['errors_sign'] = 'đăng ký thành công!';
                    }
                }
                else{
                    $_SESSION['errors_sign'] = "mật khẩu xác nhận không đúng!";
                }
                break;
            case false:
                $_SESSION['errors_sign'] = "Email không đúng định dạng!";
                break;
        }
    }

    public function show_edit($id){
        $_SESSION['data_editor'] = $this->db->get_row("SELECT * FROM users WHERE UserID = '$id'");

        header('Location: ../Views/edit.php');
        die();
    }

    public function edit($id, $fullname, $email, $pwd){
        //nếu email thay đổi kiểm tra email mới có tồn tại
        if($email != $_SESSION['data_editor']['Email']){
            if($this->db->get_row("select * from users where Email = '$email'")){
                $_SESSION['errors_edit'] = "email đã tồn tại";
                unset($_SESSION['susses_edit']);
            }
            else{
                if($pwd != '' && strlen($pwd) >= 6){
                    if($this->check_email($email)){
                        $pwd = md5(md5($pwd).$this->key_md5);

                        $update_query = "UPDATE users 
                                SET   FullName = '$fullname',
                                    Email = '$email',
                                    PassWords = '$pwd',
                                    reg_date = current_timestamp()
                                WHERE UserID = '$id'";

                        $this->db->update($update_query);
                        $_SESSION['susses_edit'] = "update thành công!";
                        unset($_SESSION['errors_edit']);
                    }
                    else{
                        $_SESSION['errors_edit'] = "email không đúng định dạng!";
                        unset($_SESSION['susses_edit']);  
                    }
                }
                else{
                    $_SESSION['errors_edit'] = "mật khẩu không được để trống và quá ngắn!";
                    unset($_SESSION['susses_edit']);
                }
            }
        }
        else{
            if($pwd != '' && strlen($pwd) >= 6){
                if($this->check_email($email)){
                    $pwd = md5(md5($pwd).$this->key_md5);

                    $update_query = "UPDATE users 
                            SET   FullName = '$fullname',
                                Email = '$email',
                                PassWords = '$pwd',
                                reg_date = current_timestamp()
                            WHERE UserID = '$id'";

                    $this->db->update($update_query);
                    $_SESSION['susses_edit'] = "update thành công!";
                    unset($_SESSION['errors_edit']);
                }
                else{
                    $_SESSION['errors_edit'] = "email không đúng định dạng!";
                    unset($_SESSION['susses_edit']);
                }
            }
            else{
                $_SESSION['errors_edit'] = "mật khẩu không được để trống và quá ngắn!";
                unset($_SESSION['susses_edit']);
            }
        }
    }

    public function delete($id){
        $this->db->delete_by_id($id);
    }

    public function is_login(){
        if (isset($_COOKIE['islogin'])) {
            if($_COOKIE['islogin'] == 1){
                return true;
            }
            else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function logout(){
        setcookie('islogin', 0, time() + 900);
        session_destroy();
        header('Location: login.php');
        die();
    }

    public function check_email($mail){
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $mail)) ? false : true;
    }
}
