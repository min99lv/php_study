<?php
    include_once "lib.php";

    //$json_data = file_get_contents('php://input');
    //$data = json_decode($json_data, true);

    $post_id = $data['post_id'];

    $password_test = $data['password']; 

    if($post_id == 0){
        msgback("오류로 인해서 다시 입력해주세요");
    }
    

    $status = 0;
    if(!$db) $db = db_conn();
    if($db){
        $sql = "SELECT `password` FROM post WHERE post_id = {$post_id}";
        $data = s_data($sql);
        $password = $data["password"];    
        
        if($password == $password_test){
            $status = 1;
            
        }
        
        echo json_encode($status);
    }


?>


