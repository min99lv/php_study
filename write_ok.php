<?php
    include_once "lib.php";

    // 입력값
    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : 0;
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $created_ip = $_SERVER['REMOTE_ADDR'];
    //$created_at = $_SERVER['REMOTE_ADDR'];
    $updated_ip = $_SERVER['REMOTE_ADDR'];
    $updated_at = date('Y-m-d H:i:s');


    print_r($_POST);

    $msg = "닉네임 : ".$nickname." 비밀번호 : ".$password." 제목 : ".$title." 내용 : ".$content;
    write_log($msg);

    // 닉네임 검증
    function nickname_check($nickname){

        if (preg_match("/^[a-zA-Z0-9]{4,8}$/", $nickname)) {
            $msg = "닉네임 통과 : 닉네임이 4자리이상 8자리 이하입니다. ";
        } else{
            $msg = "닉네임 오류: 닉네임이 4자리이상 8자리이하가 아닙니다.";
            return msgback($msg);
        }
        return write_log($msg);
    }
    

    // 비밀번호 검증
    function password_check($password){

        // echo $password;

        // 자릿수 검증
        $strlen_check = false;
        //echo strlen($password);
        if (strlen($password) >= 8 && strlen($password) <= 12) {
            $strlen_check = true;
        } 

        if($strlen_check == true){
            $msg = "비밀번호 자릿수 통과 : 비밀번호가 8자리 이상 12자리 이하입니다.";
        }else{
            $msg = "비밀번호 자릿수 오류 : 비밀번호가 8자리 이상 12자리 이하가 아닙니다.";
        }

        if($strlen_check == true){
            write_log($msg);
        }else{
            write_log($msg);
        }

        $upper_check = false; 
        $lower_check = false;
        $number_check = false; 
        $specialChar_check = false;
        
        for ($i = 0; $i < strlen($password); $i++) {
            $char = $password[$i];
            $ascii = ord($char);

            // 대문자
            if ($ascii >= 65 && $ascii <= 90){
                $upper_check = true; 
            }
            // 소문자
            if ($ascii >= 97 && $ascii <= 122){
                $lower_check = true;
            } 
            // 숫자
            if ($ascii >= 48 && $ascii <= 57){
                $number_check = true; 
            }
            // 특수문자
            if (!($ascii >= 65 && $ascii <= 90) &&!($ascii >= 97 && $ascii <= 122) && !($ascii >= 48 && $ascii <= 57)) {
                $specialChar_check = true;
            }
        }

        if($upper_check == true){
            $msg = "대문자 포함 통과 : 대문자가 존재합니다.";
            write_log($msg);
        }else{
            $msg = "대문자 포함 오류 : 대문자가 존재하지 않습니다.";
            write_log($msg);
        }

        if($lower_check == true){
            $msg = "소문자 포함 통과 : 소문자가 존재합니다.";
            write_log($msg);
        }else{
            $msg = "소문자 포함 오류 : 소문자가 존재하지 않습니다.";
            write_log($msg);
        }

        if($number_check == true){
            $msg = "숫자 포함 통과 : 숫자가 존재합니다.";
            write_log($msg);
        }else{
            $msg = "숫자 포함 오류 : 숫자가 존재하지 않습니다.";
            write_log($msg);
        }

        if($specialChar_check == true){
            $msg = "특수문자 포함 통과 : 특수문자가 존재합니다.";
            write_log($msg);
        }else{
            $msg = "특수문자 포함 오류 : 특수문자가 존재하지 않습니다.";
            write_log($msg);
        }


        if($strlen_check == true && $upper_check == true && $lower_check == true && $number_check == true && $specialChar_check == true){
            $msg = "비밀번호 모든 검증 통과";
            
        } else{
            $msg = "비밀번호 검증 오류";
        }

        return write_log($msg);
    }


    nickname_check($nickname);
    password_check($password);
    

    $db = db_conn();
    
    // 게시글 수정 
    if($db){
        $sql = "SELECT * FROM post WHERE post_id = {$post_id}";
        $rs = mysql_query($sql, $db) or die("select err");
        if(mysql_num_rows($rs) > 0){
            if($post_id > 0){
                echo $post_id;
                $sql = "UPDATE post SET title = '{$title}', content = '{$content}', nickname = '{$nickname}',`password`='{$password}', updated_at = '{$updated_at}',updated_ip = '{$updated_ip}' WHERE post_id = {$post_id}";
                $update_result = mysql_query($sql, $db) or die("update err");
                echo $title, $content, $nickname, $updated_at, $updated_ip,$post_id;
                // 게시글 작성
            }else{
                $sql = "INSERT INTO post (title,content,nickname,`password`,created_ip) values ('{$title}','{$content}','{$nickname}','{$password}','{$created_ip}')";
                $insert_result = mysql_query($sql, $db) or die("insert err");
            } 
        }else{
            msgback("해당 게시물이 존재하지 않습니다.");
        }
        
    }

    // 상세 페이지 이동
    if($insert_result){
        $post_id = sql_insert_id($db);
        movepage("view.php?post_id={$post_id}", "게시글이 성공적으로 등록되었습니다.");
    }else if($update_result) {
        movepage("view.php?post_id={$post_id}", "게시글이 성공적으로 수정되었습니다.");
    }else{
        msgback("게시글 등록이 실패했습니다.");
    }







?>