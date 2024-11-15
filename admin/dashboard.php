<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    $totclass = getTotalRecords("tblclass");
    $totstu = getTotalRecords("tblstudents");
    $totfaculty = getTotalRecords("tblfaculty");
    $totmajor = getTotalRecords("tblmajor");
}

function getTotalRecords($table)
{
    global $dbh;
    $sql = "SELECT * FROM $table";
    $query = $dbh->prepare($sql);
    $query->execute();
    return $query->rowCount();
}

function getTotalStudentsInn()
{
    global $dbh;
    $sql1 = "SELECT * FROM tblresidence WHERE ChooseCurrentAddress = 'inn'";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    return $query1->rowCount();
}

function getTotalStudentsHi()
{
    global $dbh;
    $sql1 = "SELECT * FROM tblhealthinsurance WHERE ChooseHealthInsurance = 'school'";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    return $query1->rowCount();
}

function getTotalStudentsMissingDocs()
{
    global $dbh;
    $sql = "SELECT * FROM tbldocuments WHERE 
            ChSHDang = 'Thiếu' OR
            PrvCefHS = 'Thiếu' OR
            PrvCefGradeHS = 'Thiếu' OR
            HSAcademicRec = 'Thiếu' OR
            CefHS = 'Thiếu' OR
            EnrollmentSlip = 'Thiếu' OR
            ChuyenNVQS = 'Thiếu' OR
            CefUniExam = 'Thiếu' OR
            CitizenID = 'Thiếu' OR
            BirthCef = 'Thiếu' OR
            Pic2x4 = 'Thiếu' OR
            StuCV = 'Thiếu' OR
            CefPrio = 'Thiếu' OR
            AdmissionNotice = 'Thiếu'";

    $query = $dbh->prepare($sql);
    $query->execute();
    return $query->rowCount();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>QL HSSV - Dashboard</title>
    <link rel="stylesheet" href="vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="vendors/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="vendors/chartist/chartist.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container-scroller">
        <?php include_once('includes/header.php'); ?>
        <div class="container-fluid page-body-wrapper">
            <?php include_once('includes/sidebar.php'); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-sm-flex align-items-baseline report-summary-header">
                                                <h5 class="font-weight-semibold">Báo cáo & Thống kê</h5> 
                                                <span class="ml-auto">Làm mới</span> 
                                                <button class="btn btn-icons border-0 p-2"><i class="icon-refresh"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row report-inner-cards-wrapper">
                                        <?php
                                        function displayCard($title, $count, $link)
                                        {
                                            $cardColorClass = ($count > 0) ? 'success' : 'danger';
                                            $iconType = ($count > 0) ? 'rocket' : 'user';
                                        ?>
                                            <div class="col-md-6 col-xl report-inner-card">
                                                <div class="inner-card-text">
                                                    <span class="report-title"><?php echo htmlentities($title); ?></span>
                                                    <h4><?php echo htmlentities($count); ?></h4>
                                                    <a href="<?php echo htmlentities($link); ?>"><span class="report-count"> View <?php echo htmlentities($title); ?></span></a>
                                                </div>
                                                <div class="inner-card-icon bg-<?php echo $cardColorClass; ?>">
                                                    <i class="icon-<?php echo $iconType; ?>"></i>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                        <?php displayCard("Tổng số khoa", $totfaculty, "manage-faculty.php"); ?>
                                        <?php displayCard("Tổng số ngành", $totmajor, "manage-major.php"); ?>
                                        <?php displayCard("Tổng số lớp", $totclass, "manage-class.php"); ?>
                                        <?php displayCard("Tổng số học sinh", $totstu, "manage-students.php"); ?>
                                        

                                    </div>
                                    <div class="row report-inner-cards-wrapper my-1">
                                    <?php displayCard("Sinh viên ở trọ", getTotalStudentsInn(), "show-student-inn.php"); ?>
                                        <?php displayCard("Số sinh viên tham gia BHYT tại trường", getTotalStudentsHi(), "show-student-hi.php"); ?>
                                        <?php
    displayCard("Số sinh viên còn thiếu hồ sơ", getTotalStudentsMissingDocs(), "show-student-doc.php");
    ?>
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
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/moment/moment.min.js"></script>
    <script src="vendors/daterangepicker/daterangepicker.js"></script>
    <script src="vendors/chartist/chartist.min.js"></script>
    <script src="js/off-canvas.js"></script>
    <script src="js/misc.js"></script>
    <script src="js/dashboard.js"></script>
</body>

</html>
