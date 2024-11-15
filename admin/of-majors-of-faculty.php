<?php
session_start();
include('includes/dbconnection.php');

if (empty($_SESSION['sturecmsaid'])) {
    header('location:logout.php');
    exit;
}

if (isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $sql = "DELETE FROM tblfaculty WHERE ID = :rid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':rid', $rid, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Dữ liệu đã được xóa');</script>"; 
    echo "<script>window.location.href = 'manage-faculty.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>QL HSSV - Ngành của khoa</title>
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
                        <h3 class="page-title"> Ngành của khoa </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Ngành của khoa</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Thêm phần chọn khoa -->
                                    <div class="d-sm-flex align-items-center mb-4">
                                        <h3 class="card-title mb-sm-0">Chọn khoa</h3>

                                        <select id="selectFaculty" class="form-control" onchange="loadMajors()">
                                            <option value="">Chọn khoa</option>
                                            <?php
                                            $sqlFaculties = "SELECT * FROM tblfaculty";
                                            $queryFaculties = $dbh->prepare($sqlFaculties);
                                            $queryFaculties->execute();
                                            $faculties = $queryFaculties->fetchAll(PDO::FETCH_OBJ);

                                            foreach ($faculties as $faculty) {
                                                echo "<option value='" . $faculty->FacultyName . "'>" . $faculty->FacultyName . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <!-- Kết thúc phần chọn khoa -->
                                    <h5>Ngành học của khoa: </h5>
                                    <div   id="majorList"></div>
                                    <!-- Kết thúc phần hiển thị danh sách ngành học -->
                                    
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
function loadMajors() {
var selectedFaculty = document.getElementById("selectFaculty").value;
        if (selectedFaculty != "") {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("majorList").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get-majors.php?faculty=" + selectedFaculty, true);
            xhttp.send();
        } else {
            document.getElementById("majorList").innerHTML = "";
        }
    }
</script>
</body>
</html>