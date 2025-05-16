<?php
    include_once "lib.php";

    if(!$db) $db = db_conn();    

    // ���������̼� ����
    
    // �� �������� ǥ���� �׸� ��
    $perPage = 2; 
    // ���� ������
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // ���� ������ ��ȣ
    // �����ͺ��̽����� ������ �׸� ���۹�ȣ
    $start = ($page - 1) * $perPage;
    if($db){
        $sql = "SELECT * FROM post limit $start, $perPage";
        $rs = mysql_query($sql, $db) or die (mysql_error());
    }

    $totalSql = "SELECT COUNT(*) FROM post";
    $totalRs = mysql_query($totalSql, $db) or die(mysql_error());
	$totalRow = mysql_fetch_array($totalRs);
	// ��ü �׸� �� 
    $total = $totalRow[0];
    // ��ü ������ �� 
	$totalPages = ceil($total / $perPage);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="euc-kr">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>���</title>
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
                <tr class="table-light"
                    onclick="location.href='view.php?post_id=<?=$row['post_id'] ?>&page=<?=$page?>'">
                    <th scope="row">
                        <?php 
                        // �Խñ� ��ȣ
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
                    <?php if ($page > 1){ ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                            <span aria-hidden="true">����</span>
                        </a>
                    </li>
                    <?php 
                    }                
                        // �������� ������ ��                 
                        $visiblePages = 3; 
                        // �������� ù ������ 
                        $startPage = max(1, $page - floor($visiblePages / 2));
                        // �������� �� ������
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


                    <!-- ���� ������ -->
                    <?php if ($page < $totalPages){?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                            <span aria-hidden="true">����</span>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </nav>


</body>
</div>
</div>

</html>