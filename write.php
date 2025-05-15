<?php
    include_once "lib.php";

    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

    // �Խñ� ����

    if(!$db) $db = db_conn();
    $s_data = null;
    if($post_id > 0){
        $sql = "SELECT * FROM post WHERE post_id = {$post_id}";
        $data = s_data($sql);

        $title = $data["title"];
        $content = $data["content"];
        $nickname = $data["nickname"];
        $password = $data["password"];
        $created_at = $data["created_at"];
        $created_ip = $data["created_ip"];
        
        //echo $created_ip;
    }




?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="EUC-KR">
    <title>�۾���</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
</style>
<body>
<!-- �Խñ� ���� -->
    <?php if($post_id > 0){ ?>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form class="w-50" action="write_ok.php" method="post" onsubmit="return sub();">
            <h3 class="text-center">�Խñ� ����</h3>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="�г���" required value=<?=$nickname?>>
                    <span id="nicknameCheckMessage"></span>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="password" name="password" placeholder="��й�ȣ" required value=<?=$password?>>
                    <span id="passwordCheckMessage"></span>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="title" placeholder="����" name="title" required required value=<?=$title?>>
            </div>
            <div class="mb-3">
                <textarea class="form-control" id="content" name="content" placeholder="����" rows="10" required required ><?=$content?></textarea>
            </div>
             <input type="hidden" title="post_id" name="post_id" value="<?=$post_id?>">
            <button type="submit" class="btn btn-primary">���</button>
        </form>
    </div>



    <? } else {?>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form class="w-50" action="write_ok.php" method="post" onsubmit="return sub();">
            <h3 class="text-center">�Խñ� �ۼ�</h3>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="�г���" required>
                    <span id="nicknameCheckMessage"></span>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="password" name="password" placeholder="��й�ȣ" required>
                    <span id="passwordCheckMessage"></span>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="title" placeholder="����" name="title" required>
            </div>
            <div class="mb-3">
                <textarea class="form-control" id="content" name="content" placeholder="����" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">���</button>
        </form>
    </div>

    <? } ?>
</body>

</html>

<script>
    let nick_check = false;
    let strlen_check = false;
    let upper_check = false;
    let lower_check = false;
    let number_check = false;
    let specialChar_check = false;
    let title_check = false;
    let content_check = false;   
    let password_allcheck = false;

    document.addEventListener("DOMContentLoaded", function () {
        
        document.getElementById('nickname').addEventListener("input", nickname_check);
        document.getElementById('password').addEventListener("input", password_check);
        

    });


    // �г��� Ȯ��
    function nickname_check() {
        const nickname_regex = /^[a-zA-Z0-9]{4,8}$/;
        const nickname = document.getElementById('nickname').value.trim();
        const nicknameCheckMessage = document.getElementById('nicknameCheckMessage');

        let msg = "";

        if (nickname_regex.test(nickname)) {
            msg = "�г����� ��ȿ�մϴ�.";
            nick_check = true;
        } else {
            msg = "4~8���� ����/���ڸ� ���˴ϴ�.";
            nick_check = false;
        }

        nicknameCheckMessage.textContent = msg;
        return nick_check;
    }

    // ��й�ȣ Ȯ��
    function password_check(){
        strlen_check = false;
        upper_check = false;
        lower_check = false;
        number_check = false;
        specialChar_check = false;

       const password = document.getElementById('password').value.trim();
        const passwordCheckMessage = document.getElementById('passwordCheckMessage');

         let msg = "";

        // �ڸ��� �˻�
        if (password.length >= 8 && password.length <= 12) {
            strlen_check = true;
            msg = "��й�ȣ�� 8�� �̻� 12�� �����Դϴ�.";
        } else {
            msg = "��й�ȣ�� 8�� �̻� 12�� ���ϰ� �ƴմϴ�.";
        }

        for (var i = 0; i < password.length; i++) {
            const ascii = password.charCodeAt(i);

            // �빮��
            if (ascii >= 65 && ascii <= 90) {
                upper_check = true;
            }
            // �ҹ���
            if (ascii >= 97 && ascii <= 122) {
                lower_check = true;
            }
            // ����
            if (ascii >= 48 && ascii <= 57) {
                number_check = true;
            }
            // Ư������
            if (!(ascii >= 65 && ascii <= 90) && !(ascii >= 97 && ascii <= 122) && !(ascii >= 48 && ascii <= 57)) {
                specialChar_check = true;
            }
        }

        
    msg += upper_check ? " �빮�� ����" : " �빮�� ������";
    msg += lower_check ? " �ҹ��� ����" : " �ҹ��� ������";
    msg += number_check ? " ���� ����" : " ���� ������";
    msg += specialChar_check ? " Ư������ ����" : " Ư������ ������";

    if (strlen_check && upper_check && lower_check && number_check && specialChar_check) {
        msg += " �� ��й�ȣ ��� ���� ����";
        password_allcheck = true;
    } else {
        msg += " �� ��й�ȣ ���� ����";
    }

    passwordCheckMessage.textContent = msg;

    return password_allcheck;

    }



    // �� ���� ���� ����
    function sub() {
        
        const titleInput = document.getElementById('title');
        const contentInput = document.getElementById('content');


        title_check = titleInput.value.trim() !== "";
        content_check = contentInput.value.trim() !== "";

        console.log(content_check)
        console.log(title_check)
        console.log(nickname_check())
        console.log(password_check())


        if (content_check && title_check && nickname_check() && password_check() ) {
            return true;
        } else {
            alert('����� �� �����ϴ�');
            return false;
        }
    }
</script>
