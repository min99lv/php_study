<?php
    include_once "lib.php";

    $post_id = $_POST['post_id'];
    $action = $_POST['action'];
    $password_test = $_POST['password']; 

    if($post_id == 0 && $action == ""){
        msgback("������ ���ؼ� �ٽ� �Է����ּ���");
    }
    
    if(!$db) $db = db_conn();
    

    if($db){
        $sql = "SELECT `password` FROM post WHERE post_id = {$post_id}";
        $data = s_data($sql);

        $password = $data["password"];    
        
        if($password == $password_test){
            
            // ����
            if($action == "update"){
                movepage("write.php?post_id={$post_id}", "��й�ȣ Ȯ���� �Ϸ� �Ǿ����ϴ�.");
            } else{
                movepage("delete_ok.php?post_id={$post_id}", "��й�ȣ Ȯ���� �Ϸ� �Ǿ����ϴ�.");
            }
            // ����
        }else{
            msgback("��й�ȣ�� Ʋ�Ƚ��ϴ�. �ٽ� �Է����ּ���.");
        }


        
    
    }




    


?>

