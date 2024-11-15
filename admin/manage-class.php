<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_GET['delid'])) {
        $rid = intval($_GET['delid']);
        $sql = "DELETE FROM tblclass WHERE ID=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();
        echo "<script>alert('Đã xóa lớp học');</script>"; 
        echo "<script>window.location.href = 'manage-class.php'</script>";     
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>QL HSSV - Quản lý lớp</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Quản lý lớp </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Quản lý lớp</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h4 class="card-title mb-sm-0">Quản lý lớp</h4>
                                        <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Xem tất cả các lớp</a>
                                    </div>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table" id="classTable">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">STT</th>
                                                    <th class="font-weight-bold">Tên lớp <button id="sortByClassName">Sắp xếp theo tên lớp</button></th>
                                                    <th class="font-weight-bold">Tên ngành <button id="sortByName">Sắp xếp theo tên ngành</button></th>
                                                    <th class="font-weight-bold">Thời gian tạo</th>
                                                    <th class="font-weight-bold">Sửa / Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_GET['pageno'])) {
                                                    $pageno = $_GET['pageno'];
                                                } else {
                                                    $pageno = 1;
                                                }
                                                $no_of_records_per_page = 15;
                                                $offset = ($pageno - 1) * $no_of_records_per_page;
                                                $ret = "SELECT ID FROM tblclass";
                                                $query1 = $dbh->prepare($ret);
                                                $query1->execute();
                                                $results1 = $query1->fetchAll(PDO::FETCH_OBJ);
                                                $total_rows = $query1->rowCount();
                                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                                $sql = "SELECT * from tblclass LIMIT $offset, $no_of_records_per_page";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->ClassName); ?></td>
                                                            <td><?php echo htmlentities($row->mcname); ?></td>
                                                            <td><?php echo htmlentities($row->CreationDate); ?></td>
                                                            <td>
                                                                <div><a href="edit-class-detail.php?editid=<?php echo htmlentities($row->ID); ?>"><i class="icon-eye"></i></a>
                                                                    / <a href="manage-class.php?delid=<?php echo ($row->ID); ?>" onclick="return confirm('Do you really want to Delete ?');"> <i class="icon-trash"></i></a></div>
                                                            </td>
                                                        </tr>
                                                <?php
                                                        $cnt = $cnt + 1;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div align="left">
                                        <ul class="pagination">
                                            <li><a href="?pageno=1"><strong>First></strong></a></li>
                                            <li class="<?php if ($pageno <= 1) { echo 'disabled'; } ?>">
                                                <a href="<?php if ($pageno <= 1) { echo '#'; } else { echo "?pageno=" . ($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                                            </li>
                                            <li class="<?php if ($pageno >= $total_pages) { echo 'disabled'; } ?>">
                                                <a href="<?php if ($pageno >= $total_pages) { echo '#'; } else { echo "?pageno=" . ($pageno + 1); } ?>"><strong style="padding-left: 10px">Next></strong></a>
                                            </li>
                                            <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php'); ?>
            </div>
        </div>
    </div>

    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script src="./vendors/chart.js/Chart.min.js"></script>
    <script src="./vendors/moment/moment.min.js"></script>
    <script src="./vendors/daterangepicker/daterangepicker.js"></script>
    <script src="./vendors/chartist/chartist.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="./js/dashboard.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        // Sắp xếp bảng theo tên ngành
        $('#sortByName').on('click', function () {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("classTable");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[2]; // Cột chứa tên ngành
                    y = rows[i + 1].getElementsByTagName("td")[2];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        });

        // Sắp xếp bảng theo tên lớp
        $('#sortByClassName').on('click', function () {
            var table, rows, switching, i, x, y, shouldSwitch;
            table = document.getElementById("classTable");
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("td")[1]; 
                    y = rows[i + 1].getElementsByTagName("td")[1];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                }
            }
        });
    });
</script>

</body>
</html>

