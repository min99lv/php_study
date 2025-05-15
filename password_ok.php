<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();    

    $json_data = file_get_contents('php://input');
    $data = my_json_decode($json_data, true);
    $post_id = $data['post_id'];
    $password_test = $data['password']; 


    $status = 0;
    if($db){
        $sql = "SELECT * FROM post WHERE post_id = {$post_id}";
        $rs = mysql_query($sql, $db) or die("select err");
        if(mysql_num_rows($rs) > 0){
            $sql = "SELECT `password` FROM post WHERE post_id = {$post_id}";
            $data = s_data($sql);
            $password = $data["password"];
            
            if($password == $password_test){
                $status = 1;            
            }        
            echo my_json_encode($status);
        }
        exit;
    }
?>