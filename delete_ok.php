<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();

    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;


    if($post_id == 0){
        msgback("������ �׸��� �������� �ʽ��ϴ�.");
    }

    // ���� 
    if($db){
        $sql = "DELETE FROM post WHERE post_id = ${post_id}";
        $result = mysql_query($sql, $db) or die("�Խù� ���� ����");
    }

    if($result){
        movepage("write.php?", "�Խñ��� �����Ǿ����ϴ�.");
    }




?>