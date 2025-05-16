<?php
    /*
        1. data- �Ӽ�, dataset ���۸��ؼ� ����
        2. ��� ��� ����
        3. 1�� Ȱ���ؼ� ��� 1���� ����
        4. ���� lib.php���� my_json_encode, ...decode
    */
    
    include_once "lib.php";
    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
    $page = $_GET['page'];
    //echo $page;
    //echo $post_id;
    if(!$db) $db = db_conn();

    // post_id Ȯ��
    if($db){
        $sql = "SELECT * FROM post WHERE post_id = {$post_id}";
        $rs = mysql_query($sql, $db) or die("select err");
        if(mysql_num_rows($rs) > 0){
            //echo $post_id;
            $sql = "SELECT * FROM post WHERE post_id = {$post_id}";
            // $result = mysql_query($sql, $db) or die("insert err");

            $data = s_data($sql);
            //print_r($data);

            $nickname = $data["nickname"];
            $title = $data["title"];
            $content = $data["content"];
            $created_at = $data["created_at"];
        }else{
            msgback("�ش� �Խù��� �������� �ʽ��ϴ�.");    
        }

    }


    $test = 0;
    $test2 = "";
    $test3 = NULL;
    $test4 = false;
    $test5 = array();
    if($test===$test2){
        echo "1<br>";
    }
    if($test===$test3){
        echo "2<br>";
    }
    if($test===$test4){
        echo "3<br>";
    }
    if($test2===$test3){
        echo "4<br>";
    }
    if($test2===$test4){
        echo "5<br>";
    }
    if($test3===$test4){
        echo "6<br>";
    }
    if($test===$test5){
        echo "7<br>";
    }
    if($test2==$test5){
        echo "8<br>";
    }
    if($test3===$test5){
        echo "9<br>";
    }
    if($test4===$test5){
        echo "10<br>";
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="euc-kr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>��������</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">�Խñ� �󼼺���</h4>
                    </div>

                    <div class="card-body">
                        <dl class="row mb-4">
                            <dt class="col-sm-3">�г���</dt>
                            <dd class="col-sm-9"><?= $nickname ?></dd>

                            <dt class="col-sm-3">����</dt>
                            <dd class="col-sm-9"><?= $title ?></dd>

                            <dt class="col-sm-3">����</dt>
                            <dd class="col-sm-9"><?= $content ?></dd>
                        </dl>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="location.href='list.php?page=<?=$page?>' ">���</button>
                                    
                            <button type="button" class="btn btn-outline-primary" onclick="action('update');"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                ����
                            </button>
                            <button type="button" class="btn btn-outline-danger" onclick="action('delete');"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                ����
                            </button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">��й�ȣ Ȯ��</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <input type="hidden" id="action" name="action">
                                        <input type="hidden" id="post_id" name="post_id" value="<?= $post_id ?>">
                                        <div class="modal-body">
                                            ��й�ȣ : <input type="password" id="password" name="password">
                                            <button type="button" class="btn btn-primary"
                                                onclick="password_check()">Ȯ��</button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">���</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
<script>
    function action(action) {
        console.log(action);

        const actionInput = document.getElementById('action');
        actionInput.value = action;
    }


    function password_check() {
        const post_id = document.getElementById('post_id').value;
        const password = document.getElementById('password').value;
        const action = document.getElementById('action').value;

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'password_ok.php', true);
        xhr.setRequestHeader('content-type', 'application/json');
        xhr.send(JSON.stringify({
            post_id: post_id,
            password: password
        }));

        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    var response = JSON.parse(xhr.responseText);

                    if (response == 1) {
                        if (action == "update") {
                            window.location.href = "write.php?post_id=" + post_id;
                        } else {
                            window.location.href = "delete_ok.php?post_id=" + post_id;
                        }

                    } else {
                        alert('�н����尡 ��ġ���� �ʽ��ϴ�.');
                    }
                } catch (e) {
                    console.error("JSON �Ľ� ����:", e);
                    alert('�������� �ʴ� �Խù��Դϴ�.');
                }
            }
        }
    }
</script>