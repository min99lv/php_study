<?php
    include_once "lib.php";

    $post_id = $_POST['post_id'];
    $action = $_POST['action'];
    $password_test = $_POST['password']; 

    if($post_id == 0 && $action == ""){
        msgback("오류로 인해서 다시 입력해주세요");
    }
    
    if(!$db) $db = db_conn();
    

    if($db){
        $sql = "SELECT `password` FROM post WHERE post_id = {$post_id}";
        $data = s_data($sql);

        $password = $data["password"];    
        
        if($password == $password_test){
            
            // 수정
            if($action == "update"){
                movepage("write.php?post_id={$post_id}", "비밀번호 확인이 완료 되었습니다.");
            } else{
                movepage("delete_ok.php?post_id={$post_id}", "비밀번호 확인이 완료 되었습니다.");
            }
            // 삭제
        }else{
            msgback("비밀번호가 틀렸습니다. 다시 입력해주세요.");
        }


        
    
    }




    


?>

