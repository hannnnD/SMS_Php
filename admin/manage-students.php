<?php
session_start();
include('includes/dbconnection.php');

// Redirect to logout if session is not set
if (empty($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit();
}

// Code for deletion
if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    
    // Using try-catch for error handling
    try {
        $sql = "DELETE FROM tblstudents WHERE ID = :rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_INT);
        
        if ($query->execute()) {
            echo "<script>alert('Data deleted');</script>"; 
            echo "<script>window.location.href = 'manage-students.php'</script>";     
        } else {
            echo "<script>alert('Error deleting data');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>QL HSSV - Quản lý sinh viên</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="./vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="./vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="./css/style.css">
   
  </head>

  <body>
    <div class="container-scroller">
        <?php include_once('includes/header.php');?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php');?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Quản lý sinh viên </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Quản lý sinh viên</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h4 class="card-title mb-sm-0">Quản lý sinh viên</h4>
                                        <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Xem tất cả sinh viên</a>
                                    </div>
                                    <div class="table-responsive border rounded p-1">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="font-weight-bold">STT</th>
                                                    <th class="font-weight-bold">Mã sinh viên</th>
                                                    <th class="font-weight-bold">Lớp</th>
                                                    <th class="font-weight-bold">Tên sinh viên</th>
                                                    <th class="font-weight-bold">Email</th>
                                                    <th class="font-weight-bold">Địa chỉ</th>
                                                    <th class="font-weight-bold">Số điện thoại</th>
                                                    <th class="font-weight-bold">Sửa || Xóa</th>
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
                                                
                                                // Count total records
                                                $ret = "SELECT ID FROM tblstudents";
                                                $query1 = $dbh->prepare($ret);
                                                $query1->execute();
                                                $total_rows = $query1->rowCount();
                                                $total_pages = ceil($total_rows / $no_of_records_per_page);
                                                
                                                // Fetch records for the current page
                                                $sql = "SELECT tblstudents.StudentID, tblstudents.ID as sid, tblstudents.StudentName, tblstudents.StudentEmail, tblstudents.Address, tblstudents.ContactNumber, tblclass.ClassName, tblclass.mcname 
                                                        FROM tblstudents 
                                                        JOIN tblclass ON tblclass.ID = tblstudents.StudentClass 
                                                        LIMIT $offset, $no_of_records_per_page";
                                                
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                
                                                $cnt = 1;
                                                
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $row) {
                                                ?>
                                                        <tr>
                                                            <td><?php echo htmlentities($cnt); ?></td>
                                                            <td><?php echo htmlentities($row->StudentID); ?></td>
                                                            <td><?php echo htmlentities($row->ClassName); ?> </td>
                                                            <td><?php echo htmlentities($row->StudentName); ?></td>
                                                            <td><?php echo htmlentities($row->StudentEmail); ?></td>
                                                            <td><?php echo htmlentities($row->Address); ?></td>
                                                            <td><?php echo htmlentities($row->ContactNumber); ?></td>
                                                            <td>
                                                                <div>
                                                                    <a href="edit-student-detail.php?editid=<?php echo htmlentities($row->sid); ?>"><i class="icon-eye"></i></a>
                                                                    || <a href="manage-students.php?delid=<?php echo ($row->sid); ?>" onclick="return confirm('Do you really want to Delete ?');"><i class="icon-trash"></i></a>
                                                                </div>
                                                            </td> 
                                                        </tr>
                                                <?php
                                                        $cnt++;
                                                    }
                                                }
                                                ?>
                                                
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                    <div align="left">
                                        <ul class="pagination" >
                                            <li><a href="?pageno=1"><strong>First></strong></a></li>
                                            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Prev></strong></a>
                                            </li>
                                            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Next></strong></a>
                                            </li>
                                            <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Last</strong></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once('includes/footer.php');?>
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
</body>

</html>

