<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit;
}

if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE FROM tblclass WHERE ID = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Dữ liệu đã được xóa');</script>"; 
    echo "<script>window.location.href = 'manage-majors.php'</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>QL HSSV - Sinh viên của lớp</title>
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
                        <h3 class="page-title"> Sinh viên của lớp </h3>
                        <!-- Your breadcrumb navigation -->
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Thêm phần chọn lớp -->
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h3 class="card-title mb-sm-0">Chọn lớp</h3>
                                        <select id="selectClass" class="form-control" onchange="loadStudents()">
                                            <option value="">Chọn lớp</option>
                                            <?php
                                            // Retrieve the list of classes from your database
                                            $sqlClasses = "SELECT * FROM tblclass";
                                            $queryClasses = $dbh->prepare($sqlClasses);
                                            $queryClasses->execute();
                                            $classes = $queryClasses->fetchAll(PDO::FETCH_OBJ);

                                            foreach ($classes as $class) {
                                                echo "<option value='" . $class->ID . "'>" . $class->ClassName . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- Kết thúc phần chọn lớp -->
                                    <h5>Danh sách sinh viên</h5>
                                    <div id="studentsList"></div>
                                    <!-- Kết thúc phần hiển thị danh sách sinh viên -->
                                    
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
    <script>
    function loadStudents() {
        var selectedClass = document.getElementById("selectClass").value;
        if (selectedClass != "") {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("studentsList").innerHTML = this.responseText;
                }
            };
            xhttp.onerror = function () {
                document.getElementById("studentsList").innerHTML = 'Error occurred while fetching data.';
            };
            xhttp.open("GET", "get-students.php?class=" + selectedClass, true);
            xhttp.send();
        } else {
            document.getElementById("studentsList").innerHTML = "";
        }
    }
</script>

</body>
</html>
