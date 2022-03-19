<?php 
require_once 'DB.php';
class DB_User extends DB{

    protected $table_name = 'users', $_key = 'UserID';

    function __construct() {
        parent::connect();
    }
     
    public function disconnected() {
        parent::dis_connect();
    }

    function add_new($sql){
        mysqli_query(mysqli_connect('localhost', 'root', '', 'mini_project'), $sql);
        mysqli_close(mysqli_connect('localhost', 'root', '', 'mini_project'));
    }

    function delete_by_id($id){
        $this->excute("DELETE FROM users WHERE UserID  = '$id'");
    }

    function update($sql){
        mysqli_query(mysqli_connect('localhost', 'root', '', 'mini_project'), $sql);
        mysqli_close(mysqli_connect('localhost', 'root', '', 'mini_project'));
    }

    function select_row($sql){
        return $this->get_row($sql);
    }

    function select_list($sql){
        $result = mysqli_query(mysqli_connect('localhost', 'root', '', 'mini_project'), $sql);
        $data = [];

        while($row = mysqli_fetch_array($result, 1)){
            $data[] = $row;
        }

        mysqli_close(mysqli_connect('localhost', 'root', '', 'mini_project'));
        return $data;
    }
}

?>