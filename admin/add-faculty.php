<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit;
}

if (isset($_POST['submit'])) {
    $fid = $_POST['fid'];
    $fname = $_POST['fname'];

    $sql = "INSERT INTO tblfaculty(fid, FacultyName) VALUES (:fid, :fname)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fid', $fid, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->execute();

    $LastInsertId = $dbh->lastInsertId();

    if ($LastInsertId > 0) {
        echo '<script>alert("Khoa đã được thêm.")</script>';
        echo "<script>window.location.href ='add-faculty.php'</script>";
    } else {
        echo '<script>alert("Có lỗi xảy ra, vui lòng thử lại!")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
   
    <title>QL HSSV - Thêm khoa</title>
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
              <h3 class="page-title"> Thêm khoa </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Thêm</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title" style="text-align: center;">Thêm khoa</h4>
                    <form class="forms-sample" method="post">
                      <div class="form-group">
                        <label for="exampleInputName1">Mã Khoa</label>
                        <input type="text" name="fid" value="" class="form-control" required='true' maxlength="10" >
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Tên Khoa</label>
                        <input type="text" name="fname" value="" class="form-control" required='true'>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2" name="submit">Thêm</button>
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