<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();    

    // ���������̼� ����
    $perPage = 2; // �� �������� ǥ���� �׸� ��
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // ���� ������ ��ȣ
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
    <title>���</title>
</head>

<body>

    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">�� ��ȣ</th>
                <th scope="col">����</th>
                <th scope="col">�г���</th>
                <th scope="col">�ۼ�����</th>
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
            echo "��ϵ� �Խñ��� �����ϴ�.";
        
        }?>
        </tbody>
    </table>

    <div class="mt-4 d-flex justify-content-center">

            <!-- ���������̼� -->
            <nav aria-label="Page navigation" class="pagination-default">
                <ul class="pagination">
                    
                    <!-- ���� ������ -->
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">����</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php                
                    $visiblePages = 3; // �������� ������ ��                 
                    $startPage = max(1, $page - floor($visiblePages / 2)); // �������� ���� ������
                    $endPage = $startPage + $visiblePages - 1; // �������� �� ������
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

                    <!-- ���� ������ -->
                    <?php if ($page < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">����</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

</body>

</html>