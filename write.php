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
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form class="w-50" action="write_ok.php" method="post" onsubmit="return sub();">
            <h3 class="text-center">글작성</h3>
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


    const titleInput = document.getElementById('title');
    const contentInput = document.getElementById('content');
    
    // 제목 검증
        if (titleInput.value.trim() === "") {
            title_check = false;
        } else {
            title_check = true;
        }


    // 내용 검증
        if (contentInput.value.trim() === "") {
            content_check = false;
        } else {
            content_check = true;
        }


    document.addEventListener("DOMContentLoaded", function () {
        // 닉네임 검증
        const nicknameInput = document.getElementById('nickname');
        const nicknameCheckMessage = document.getElementById('nicknameCheckMessage');
        const nickname_regex = /^[a-zA-Z0-9]{4,8}$/;

        nicknameInput.addEventListener("input", function () {
            // 초기화
            nick_check = false;
            let msg = "";

            const nickname = nicknameInput.value;

            // 자릿수 검사
            if (nickname_regex.test(nickname)) {
                msg = "닉네임이 4자 이상 8자 이하입니다.";
                nick_check = true;
            } else {
                msg = "닉네임이 4자 이상 8자 이하가 아닙니다.";
            }

            nicknameCheckMessage.textContent = msg;
        });

        // 비밀번호 검증
        const passwordInput = document.getElementById('password');
        const passwordCheckMessage = document.getElementById('passwordCheckMessage');

        passwordInput.addEventListener("input", function () {

            strlen_check = false;
            upper_check = false;
            lower_check = false;
            number_check = false;
            specialChar_check = false;

            const password = passwordInput.value;
            let msg = "";

            // 자릿수 검사
            if (password.length >= 8 && password.length <= 12) {
                strlen_check = true;
                msg = "비밀번호가 8자 이상 12자 이하입니다.";
            } else {
                msg = "비밀번호가 8자 이상 12자 이하가 아닙니다.";
            }

            for (var i = 0; i < password.length; i++) {
                var char = password[i];
                var ascii = char.charCodeAt(0);

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

            if (upper_check) {
                msg += " 대문자 포함";
            } else {
                msg += " 대문자 미포함";
            }

            if (lower_check) {
                msg += " 소문자 포함";
            } else {
                msg += " 소문자 미포함";
            }

            if (number_check) {
                msg += " 숫자 포함";
            } else {
                msg += " 숫자 미포함";
            }

            if (specialChar_check) {
                msg += " 특수문자 포함";
            } else {
                msg += " 특수문자 미포함";
            }

            if (strlen_check && upper_check && lower_check && number_check && specialChar_check) {
                msg += " 비밀번호 모든 검증 통과";
            } else {
                msg += " 비밀번호 검증 오류";
            }

            passwordCheckMessage.textContent = msg;
        });
    });

    // 폼 제출 전에 검증
    function sub() {
        console.log("nick_check:", nick_check);
        console.log("strlen_check:", strlen_check);
        console.log("upper_check:", upper_check);
        console.log("lower_check:", lower_check);
        console.log("number_check:", number_check);
        console.log("specialChar_check:", specialChar_check);

        if (content_check && title_check && nick_check && strlen_check && upper_check && lower_check && number_check && specialChar_check) {
            return true;
        } else {
            alert('등록할 수 없습니다');
            return false;
        }
    }
</script>
