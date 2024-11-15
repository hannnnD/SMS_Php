<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $fid = $_POST['fid'];
        $fname = $_POST['fname'];
        $eid = $_GET['editid'];

        $sql = "UPDATE tblfaculty SET fid=:fid, FacultyName=:fname WHERE ID=:eid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fid', $fid, PDO::PARAM_STR);
        $query->bindParam(':fname', $fname, PDO::PARAM_STR);
        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
        $query->execute();

        echo '<script>alert("Thông tin khoa đã được cập nhật")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>QL HSSV - Quản lý khoa</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css" />
    
  </head>

  <body>
    <div class="container-scroller">
        <?php include_once('includes/header.php');?>

        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php');?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title"> Quản lý khoa </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Quản lý khoa</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Quản lý khoa</h4>
                                    <form class="forms-sample" method="post">
                                        <?php
                                        $eid = $_GET['editid'];
                                        $sql = "SELECT * from  tblfaculty where ID=$eid";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $row) {
                                        ?>
                                                <div class="form-group">
                                                    <label for="exampleInputName1">Mã khoa</label>
                                                    <input type="text" name="fid" value="<?php echo htmlentities($row->fid); ?>" class="form-control" required='true'>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputName1">Tên khoa</label>
                                                    <input type="text" name="fname" value="<?php echo htmlentities($row->FacultyName); ?>" class="form-control" required='true'>
                                                </div>
                                        <?php
                                                $cnt = $cnt + 1;
                                            }
                                        }
                                        ?>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Cập nhật</button>
                                    </form>
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
    <script src="vendors/select2/select2.min.js"></script>
    <script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/typeahead.js"></script>
    <script src="js/select2.js"></script>
</body>

</html>