<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();

    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;


    if($post_id == 0){
        msgback("삭제할 항목이 존재하지 않습니다.");
    }

    // 삭제 
    if($db){
        $sql = "DELETE FROM post WHERE post_id = ${post_id}";
        $result = mysql_query($sql, $db) or die("게시물 삭제 에러");
    }

    if($result){
        movepage("write.php?", "게시글이 삭제되었습니다.");
    }




?>