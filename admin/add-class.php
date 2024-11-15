<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $cname = $_POST['cname'];
        $mcname = $_POST['mcname'];

        $sql = "INSERT INTO tblclass(ClassName, mcname) VALUES (:cname, :mcname)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':cname', $cname, PDO::PARAM_STR);
        $query->bindParam(':mcname', $mcname, PDO::PARAM_STR);
        $query->execute();

        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId > 0) {
            echo '<script>alert("Lớp đã được thêm.")</script>';
            echo "<script>window.location.href ='add-class.php'</script>";
        } else {
            echo '<script>alert("Có lỗi xảy ra. Vui lòng thử lại.")</script>';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>QL HSSV - Thêm lớp</title>
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
                        <h3 class="page-title"> Thêm lớp </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Thêm lớp</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Thêm lớp</h4>
                                    <form class="forms-sample" method="post">
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Chọn ngành</label>
                                            <select name="mcname" class="form-control" required='true'>
                                                <option value="">Chọn ngành</option>
                                                <?php 
                                                    $sql2 = "SELECT * FROM tblmajor";
                                                    $query2 = $dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                    foreach($result2 as $row1) { ?>  
                                                        <option value="<?php echo htmlentities($row1->MajorName);?>">
                                                            
                                                            <?php echo htmlentities($row1->MajorName);?>
                                                        </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Tên lớp</label>
                                            <input type="text" name="cname" class="form-control" required='true'>
                                        </div>
                                        <button type="submit" class="btn btn-primary mr-2" name="submit">Thêm lớp</button>
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