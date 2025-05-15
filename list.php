<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();    

    // 페이지네이션 설정
    $perPage = 2; // 한 페이지당 표시할 항목 수
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // 현재 페이지 번호
    $start = ($page - 1) * $perPage;
    if($db){
        $sql = "SELECT * FROM post limit $start, $perPage";
        $rs = mysql_query($sql, $db) or die (mysql_error());
    }

    $totalSql = "SELECT COUNT(*) FROM post";


    $totalRs = mysql_query($totalSql, $db) or die(mysql_error());
	$totalRow = mysql_fetch_array($totalRs);
	$total = $totalRow[0];
	$totalPages = ceil($total / $perPage);

?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="euc-kr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>목록</title>
</head>

<body>

    <table class="table table-hover">
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
            <tr onclick="location.href='view.php?post_id=<?=$row['post_id'] ?>&page=<?=$page?>'">
                <th scope="row"> 
                    <?php 
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
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">이전</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php                
                    $visiblePages = 3; // 보여지는 페이지 수                 
                    $startPage = max(1, $page - floor($visiblePages / 2)); // 보여지는 시작 페이지
                    $endPage = $startPage + $visiblePages - 1; // 보여지는 끝 페이지
                    if ($endPage > $totalPages) {
                        $endPage = $totalPages;
                        $startPage = max(1, $endPage - $visiblePages + 1);
                    }
                    


                    for ($i = $startPage; $i <= $endPage; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php                

                    ?>

                    <!-- 다음 페이지 -->
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">다음</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

</body>

</html>