<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (empty($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
} elseif (isset($_POST['submit'])) {
    $cname = $_POST['cname'];
    $section = $_POST['mcname'];
    $eid = $_GET['editid'];

    $sql = "UPDATE tblclass SET ClassName=:cname, mcname=:mcname WHERE ID=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':cname', $cname, PDO::PARAM_STR);
    $query->bindParam(':mcname', $section, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->execute();

    echo '<script>alert("Lớp học đã được cập nhật")</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>QL HSSV - Quản lý lớp</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/select2/select2.min.css">
    <link rel="stylesheet" href="vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css"/>
</head>

<body>
<div class="container-scroller">
    <?php include_once('includes/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
        <?php include_once('includes/sidebar.php'); ?>
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="page-header">
                    <h3 class="page-title"> Manage Class </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"> Manage Class</li>
                        </ol>
                    </nav>
                </div>
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" style="text-align: center;">Manage Class</h4>

                                <form class="forms-sample" method="post">
                                    <?php
                                    $eid = $_GET['editid'];
                                    $sql = "SELECT * from  tblclass where ID=$eid";
                                    $query = $dbh->prepare($sql);
                                    $query->execute();
                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt = 1;
                                    if ($query->rowCount() > 0) {
                                        foreach ($results as $row) {
                                            ?>
                                            <div class="form-group">
                                                <label for="exampleInputName1">Class Name</label>
                                                <input type="text" name="cname" value="<?php echo htmlentities($row->ClassName); ?>" class="form-control" required='true'>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleInputEmail3">Select Major</label>
                                                <select name="mcname" class="form-control" required='true'>
                                                    <option value="<?php echo htmlentities($row->mcname); ?>"><?php echo htmlentities($row->mcname); ?></option>
                                                    <?php
                                                    $sql2 = "SELECT * FROM tblmajor";
                                                    $query2 = $dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                    foreach ($result2 as $row2) {
                                                        ?>
                                                        <option value="<?php echo htmlentities($row2->MajorName); ?>">
                                                            <?php echo htmlentities($row2->fmid); ?>
                                                            <?php echo htmlentities($row2->MajorName); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <?php $cnt = $cnt + 1;
                                        }
                                    } ?>
                                    <button type="submit" class="btn btn-primary mr-2" name="submit">Update</button>
                                </form>
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
<script src="vendors/select2/select2.min.js"></script>
<script src="vendors/typeahead.js/typeahead.bundle.min.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/misc.js"></script>
<script src="js/typeahead.js"></script>
<script src="js/select2.js"></script>
</body>
</html>
