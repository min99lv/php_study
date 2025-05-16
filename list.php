<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();    

    // 페이지네이션 설정
    
    // 한 페이지당 표시할 항목 수
    $perPage = 2; 
    // 현재 페이지
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 현재 페이지 번호
    // 데이터베이스에서 가져올 항목 시작번호
    $start = ($page - 1) * $perPage;
    if($db){
        $sql = "SELECT * FROM post limit $start, $perPage";
        $rs = mysql_query($sql, $db) or die (mysql_error());
    }

    $totalSql = "SELECT COUNT(*) FROM post";
    $totalRs = mysql_query($totalSql, $db) or die(mysql_error());
	$totalRow = mysql_fetch_array($totalRs);
	// 전체 항목 수 
    $total = $totalRow[0];
    // 전체 페이지 수 
	$totalPages = ceil($total / $perPage);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="euc-kr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>목록</title>
</head>
<style>
.container-md {
    margin-top: 100px;
}

.navbar-nav {
    align-items: center;
    display: flex;
    margin: 0 auto;
    flex-direction: row;
    justify-content: center;
}

.page-link {
    color: black;
}

.active>.page-link,
.page-link.active {
    background-color: #000000;
    border-color: #000000;
}
</style>

<body>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-md">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th scope="col">글 번호</th>
                    <th scope="col">제목</th>
                    <th scope="col">닉네임</th>
                    <th scope="col">작성일자</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysql_num_rows($rs) > 0) {
        $i = 0;
        while ($row = mysql_fetch_array($rs)){
          //  print_r($row);
        $i++;
        ?>
                <tr class="table-light"
                    onclick="location.href='view.php?post_id=<?=$row['post_id'] ?>&page=<?=$page?>'">
                    <th scope="row">
                        <?php 
                        // 게시글 번호
                        $displayNum = $total - (($page - 1) * $perPage + ($i - 1));
                        echo $displayNum;
                        ?>
                    </th>
                    <td><?=$row["title"]?></td>
                    <td><?=$row["nickname"]?></td>
                    <td><?=$row["created_at"]?></td>
                </tr>
                <? }; } else{
            echo "등록된 게시글이 없습니다.";
        
        }?>
            </tbody>
        </table>

        <div class="mt-4 d-flex justify-content-center">

            <!-- 페이지네이션 -->
            <nav aria-label="Page navigation" class="pagination-default">
                <ul class="pagination">

                    <!-- 이전 페이지 -->
                    <?php if ($page > 1){ ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">이전</span>
                        </a>
                    </li>
                    <?php 
                    }                
                        // 보여지는 페이지 수                 
                        $visiblePages = 3; 
                        // 보여지는 첫 페이지 
                        $startPage = max(1, $page - floor($visiblePages / 2));
                        // 보여지는 끝 페이지
                        $endPage = $startPage + $visiblePages - 1; 
                        if ($endPage > $totalPages) {
                            $endPage = $totalPages;
                            $startPage = max(1, $endPage - $visiblePages + 1);
                    }
                    


                    for ($i = $startPage; $i <= $endPage; $i++){ ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                    <?php } ?>


                    <!-- 다음 페이지 -->
                    <?php if ($page < $totalPages){?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">다음</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>


</body>
</div>
</div>

</html>