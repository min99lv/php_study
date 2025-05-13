<?php

    function write_log($msg) {    
        $log_file = dirname(__FILE__) . '/write_log.log';
        $date = date('Y-m-d H:i:s');
        $log_message = "[$date]  $msg" . PHP_EOL;
        if ($handle = @fopen($log_file, 'a')) {        
            $result = fwrite($handle, $log_message);
            fclose($handle);
            return ($result !== false);
        }    
        return false;
    }

    // �Է°�
    $nickname = $_POST['nickname'];
    $password = $_POST['password'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    print_r($_POST);

    $msg = "�г��� : ".$nickname." ��й�ȣ : ".$password." ���� : ".$title." ���� : ".$content;
    write_log($msg);
    
    // ���� ����
        if(trim($title) == ""){
            $msg = "������ ��ĭO.";
        } else{
            $msg = "���� ��ĭ X";
        }
    // ���� ����
        if(trim($content) == ""){
            $msg = "������ ��ĭO.";
        } else{
            $msg = "���� ��ĭ X";
        }

    // �г��� ����
    function nickname_check($nickname){

        if (preg_match("/^[a-zA-Z0-9]{4,8}$/", $nickname)) {
            $msg = "�г��� ��� : �г����� 4�ڸ��̻� 8�ڸ� �����Դϴ�. ";
        } else{
            $msg = "�г��� ����: �г����� 4�ڸ��̻� 8�ڸ����ϰ� �ƴմϴ�.";
        }
        return write_log($msg);
    }
    

    // ��й�ȣ ����
    function password_check($password){

        // echo $password;

        // �ڸ��� ����
        $strlen_check = false;
        echo strlen($password);
        if (strlen($password) >= 8 && strlen($password) <= 12) {
            $strlen_check = true;
        } 

        if($strlen_check == true){
            $msg = "��й�ȣ �ڸ��� ��� : ��й�ȣ�� 8�ڸ� �̻� 12�ڸ� �����Դϴ�.";
        }else{
            $msg = "��й�ȣ �ڸ��� ���� : ��й�ȣ�� 8�ڸ� �̻� 12�ڸ� ���ϰ� �ƴմϴ�.";
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

            // �빮��
            if ($ascii >= 65 && $ascii <= 90){
                $upper_check = true; 
            }
            // �ҹ���
            if ($ascii >= 97 && $ascii <= 122){
                $lower_check = true;
            } 
            // ����
            if ($ascii >= 48 && $ascii <= 57){
                $number_check = true; 
            }
            // Ư������
            if (!($ascii >= 65 && $ascii <= 90) &&!($ascii >= 97 && $ascii <= 122) && !($ascii >= 48 && $ascii <= 57)) {
                $specialChar_check = true;
            }
        }

        if($upper_check == true){
            $msg = "�빮�� ���� ��� : �빮�ڰ� �����մϴ�.";
            write_log($msg);
        }else{
            $msg = "�빮�� ���� ���� : �빮�ڰ� �������� �ʽ��ϴ�.";
            write_log($msg);
        }

        if($lower_check == true){
            $msg = "�ҹ��� ���� ��� : �ҹ��ڰ� �����մϴ�.";
            write_log($msg);
        }else{
            $msg = "�ҹ��� ���� ���� : �ҹ��ڰ� �������� �ʽ��ϴ�.";
            write_log($msg);
        }

        if($number_check == true){
            $msg = "���� ���� ��� : ���ڰ� �����մϴ�.";
            write_log($msg);
        }else{
            $msg = "���� ���� ���� : ���ڰ� �������� �ʽ��ϴ�.";
            write_log($msg);
        }

        if($specialChar_check == true){
            $msg = "Ư������ ���� ��� : Ư�����ڰ� �����մϴ�.";
            write_log($msg);
        }else{
            $msg = "Ư������ ���� ���� : Ư�����ڰ� �������� �ʽ��ϴ�.";
            write_log($msg);
        }


        if($strlen_check == true && $upper_check == true && $lower_check == true && $number_check == true && $specialChar_check == true){
            $msg = "��й�ȣ ��� ���� ���";
            
        } else{
            $msg = "��й�ȣ ���� ����";
        }

        return write_log($msg);
    }


    nickname_check($nickname);
    password_check($password);
    


?>