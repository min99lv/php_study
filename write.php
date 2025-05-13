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
    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <form class="w-50" action="write_ok.php" method="post" onsubmit="return sub();">
            <h3 class="text-center">���ۼ�</h3>
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
    
    // ���� ����
        if (titleInput.value.trim() === "") {
            title_check = false;
        } else {
            title_check = true;
        }


    // ���� ����
        if (contentInput.value.trim() === "") {
            content_check = false;
        } else {
            content_check = true;
        }


    document.addEventListener("DOMContentLoaded", function () {
        // �г��� ����
        const nicknameInput = document.getElementById('nickname');
        const nicknameCheckMessage = document.getElementById('nicknameCheckMessage');
        const nickname_regex = /^[a-zA-Z0-9]{4,8}$/;

        nicknameInput.addEventListener("input", function () {
            // �ʱ�ȭ
            nick_check = false;
            let msg = "";

            const nickname = nicknameInput.value;

            // �ڸ��� �˻�
            if (nickname_regex.test(nickname)) {
                msg = "�г����� 4�� �̻� 8�� �����Դϴ�.";
                nick_check = true;
            } else {
                msg = "�г����� 4�� �̻� 8�� ���ϰ� �ƴմϴ�.";
            }

            nicknameCheckMessage.textContent = msg;
        });

        // ��й�ȣ ����
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

            // �ڸ��� �˻�
            if (password.length >= 8 && password.length <= 12) {
                strlen_check = true;
                msg = "��й�ȣ�� 8�� �̻� 12�� �����Դϴ�.";
            } else {
                msg = "��й�ȣ�� 8�� �̻� 12�� ���ϰ� �ƴմϴ�.";
            }

            for (var i = 0; i < password.length; i++) {
                var char = password[i];
                var ascii = char.charCodeAt(0);

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

            if (upper_check) {
                msg += " �빮�� ����";
            } else {
                msg += " �빮�� ������";
            }

            if (lower_check) {
                msg += " �ҹ��� ����";
            } else {
                msg += " �ҹ��� ������";
            }

            if (number_check) {
                msg += " ���� ����";
            } else {
                msg += " ���� ������";
            }

            if (specialChar_check) {
                msg += " Ư������ ����";
            } else {
                msg += " Ư������ ������";
            }

            if (strlen_check && upper_check && lower_check && number_check && specialChar_check) {
                msg += " ��й�ȣ ��� ���� ���";
            } else {
                msg += " ��й�ȣ ���� ����";
            }

            passwordCheckMessage.textContent = msg;
        });
    });

    // �� ���� ���� ����
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
            alert('����� �� �����ϴ�');
            return false;
        }
    }
</script>
