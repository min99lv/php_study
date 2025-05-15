<?php
    /*
        1. data- 속성, dataset 구글링해서 공부
        2. 모달 방식 수정
        3. 1번 활용해서 모달 1개로 가능
        4. 기존 lib.php에서 my_json_encode, ...decode
    */
    
    include_once "lib.php";
    $post_id = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;

    if(!$db) $db = db_conn();
    if($db) {
        //echo $post_id;
        $sql = "SELECT * FROM post WHERE post_id = {$post_id}";
        // $result = mysql_query($sql, $db) or die("insert err");

        $data = s_data($sql);
        //print_r($data);

        $nickname = $data["nickname"];
        $title = $data["title"];
        $content = $data["content"];
        $created_at = $data["created_at"];
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="euc-kr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>상세페이지</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<!-- modal ex -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
수정하기
</button>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- modal ex -->
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">게시글 상세보기</h4>
                    </div>

                    <div class="card-body">
                        <dl class="row mb-4">
                            <dt class="col-sm-3">닉네임</dt>
                            <dd class="col-sm-9"><?= $nickname ?></dd>

                            <dt class="col-sm-3">제목</dt>
                            <dd class="col-sm-9"><?= $title ?></dd>

                            <dt class="col-sm-3">내용</dt>
                            <dd class="col-sm-9"><?= $content ?></dd>
                        </dl>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="location.href='list.php' ">목록</button>
                            <!-- <button type="button" class="btn btn-outline-primary"
                                onclick="location.href='write.php?post_id=<?= $post_id ?>'">수정</button>
                            <button type="button" class="btn btn-outline-danger"
                                onclick="location.href='delete_ok.php?post_id=<?= $post_id ?>'">삭제</button> -->

                                <!-- 수정 버튼 -->
                                <button type="button" class="btn btn-outline-primary" onclick="openModal('update', <?= $post_id ?>)">수정</button>

                                <!-- 삭제 버튼 -->
                                <button type="button" class="btn btn-outline-danger" onclick="openModal('delete', <?= $post_id ?>)">삭제</button>

                                <!-- Modal -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">비밀번호 확인</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="닫기"></button>
                                        </div>
                                        <div class="modal-body">
                                        <input type="hidden" name="post_id" id="post_id">
                                        <input type="hidden" name="action" id="action">
                                        <div class="mb-3">
                                            <label for="passwordInput" class="form-label">비밀번호</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button>
                                        <button type="submit" class="btn btn-primary" onclick="password_check()">확인</button>
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
    function openModal(action, post_id) {
        //console.log(post_id);

        document.getElementById('post_id').value = post_id;
        document.getElementById('action').value = action;

        // Bootstrap 모달 수동 제어
        const modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
        modal.show();
    }

    
    async function password_check() {
        const post_id = document.getElementById('post_id').value;
        const password = document.getElementById('password').value;
        const action = document.getElementById('action').value;

        //console.log(post_id);
        //console.log(password);
        try {
            const response = await fetch('/notice_board/password_ok.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ post_id: post_id, password: password })
            });

            const data = await response.json();
            console.log(data);
            if (data == 1) {
                //alert('패스워드가 일치합니다.');
                if(action == "update"){
                    window.location.href = "/notice_board/write.php?post_id="+post_id;
                }else{
                    window.location.href = "/notice_board/delete_ok.php?post_id=post_id";
                }
                
            } else {
                alert('패스워드가 일치하지 않습니다.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }
           





    

</script>