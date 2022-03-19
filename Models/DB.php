<?php 
class DB{
    private $conn;

    public function connect(){
        //kiểm tra kết nối
        if (!$this->conn){
            $this->conn = mysqli_connect('localhost', 'root', '', 'mini_project') or die ('Lỗi kết nối');
        }
    }

    function dis_connect(){
        //kiểm tra kết nối
        if ($this->conn){
            mysqli_close($this->conn);
        }
    }

    function excute($sql)
    {
        try{
            // Kết nối
            $this->connect();   

            mysqli_query($this->conn, $sql);

            //ngắt kết nối
            $this->dis_connect();
        }
        catch(Exception $e){
            echo $e->getMessage();
        }
    }
 
    function remove($table, $where){
        // Kết nối
        $this->connect();
         
        // Delete
        $sql = "DELETE FROM $table WHERE $where";
        mysqli_query($this->conn, $sql);

        //ngắt kết nối
        $this->dis_connect();
    }

    public function get_list($sql){
        // Kết nối
        $this->connect();  

        $result= mysqli_query($this->conn, $sql);
        $list_data=[];

        while($row= mysqli_fetch_array($result, 1)){
            $list_data[]=$row;
        }

        //ngắt kết nối
        $this->dis_connect();
        return $list_data;
    }

    public function get_row($sql){
        // Kết nối
        $this->connect();  

        $result= mysqli_query($this->conn, $sql);
        $data= mysqli_fetch_array($result, 1);

        //ngắt kết nối
        $this->dis_connect();
        return $data;
    }
}

?>