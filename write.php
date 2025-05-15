<?php
    include_once "lib.php";

    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

    // 게시글 수정

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
    <title>글쓰기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
</style>
<body>
<!-- 게시글 수정 -->
    <?php if($post_id > 0){ ?>
        <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form class="w-50" action="write_ok.php" method="post" onsubmit="return sub();">
            <h3 class="text-center">게시글 수정</h3>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="닉네임" required value=<?=$nickname?>>
                    <span id="nicknameCheckMessage"></span>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="password" name="password" placeholder="비밀번호" required value=<?=$password?>>
                    <span id="passwordCheckMessage"></span>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="title" placeholder="제목" name="title" required required value=<?=$title?>>
            </div>
            <div class="mb-3">
                <textarea class="form-control" id="content" name="content" placeholder="내용" rows="10" required required ><?=$content?></textarea>
            </div>
             <input type="hidden" title="post_id" name="post_id" value="<?=$post_id?>">
            <button type="submit" class="btn btn-primary">등록</button>
        </form>
    </div>



    <? } else {?>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form class="w-50" action="write_ok.php" method="post" onsubmit="return sub();">
            <h3 class="text-center">게시글 작성</h3>
            <div class="row mb-3">
                <div class="col">
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="닉네임" required>
                    <span id="nicknameCheckMessage"></span>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="password" name="password" placeholder="비밀번호" required>
                    <span id="passwordCheckMessage"></span>
                </div>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="title" placeholder="제목" name="title" required>
            </div>
            <div class="mb-3">
                <textarea class="form-control" id="content" name="content" placeholder="내용" rows="10" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">등록</button>
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


    // 닉네임 확인
    function nickname_check() {
        const nickname_regex = /^[a-zA-Z0-9]{4,8}$/;
        const nickname = document.getElementById('nickname').value.trim();
        const nicknameCheckMessage = document.getElementById('nicknameCheckMessage');

        let msg = "";

        if (nickname_regex.test(nickname)) {
            msg = "닉네임이 유효합니다.";
            nick_check = true;
        } else {
            msg = "4~8자의 영문/숫자만 허용됩니다.";
            nick_check = false;
        }

        nicknameCheckMessage.textContent = msg;
        return nick_check;
    }

    // 비밀번호 확인
    function password_check(){
        strlen_check = false;
        upper_check = false;
        lower_check = false;
        number_check = false;
        specialChar_check = false;

       const password = document.getElementById('password').value.trim();
        const passwordCheckMessage = document.getElementById('passwordCheckMessage');

         let msg = "";

        // 자릿수 검사
        if (password.length >= 8 && password.length <= 12) {
            strlen_check = true;
            msg = "비밀번호가 8자 이상 12자 이하입니다.";
        } else {
            msg = "비밀번호가 8자 이상 12자 이하가 아닙니다.";
        }

        for (var i = 0; i < password.length; i++) {
            const ascii = password.charCodeAt(i);

            // 대문자
            if (ascii >= 65 && ascii <= 90) {
                upper_check = true;
            }
            // 소문자
            if (ascii >= 97 && ascii <= 122) {
                lower_check = true;
            }
            // 숫자
            if (ascii >= 48 && ascii <= 57) {
                number_check = true;
            }
            // 특수문자
            if (!(ascii >= 65 && ascii <= 90) && !(ascii >= 97 && ascii <= 122) && !(ascii >= 48 && ascii <= 57)) {
                specialChar_check = true;
            }
        }

        
    msg += upper_check ? " 대문자 포함" : " 대문자 미포함";
    msg += lower_check ? " 소문자 포함" : " 소문자 미포함";
    msg += number_check ? " 숫자 포함" : " 숫자 미포함";
    msg += specialChar_check ? " 특수문자 포함" : " 특수문자 미포함";

    if (strlen_check && upper_check && lower_check && number_check && specialChar_check) {
        msg += " → 비밀번호 모든 조건 만족";
        password_allcheck = true;
    } else {
        msg += " → 비밀번호 조건 부족";
    }

    passwordCheckMessage.textContent = msg;

    return password_allcheck;

    }



    // 폼 제출 전에 검증
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
            alert('등록할 수 없습니다');
            return false;
        }
    }
</script>
