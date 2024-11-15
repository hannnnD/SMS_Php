<?php
session_start();
error_reporting(E_ALL);
include('includes/dbconnection.php');

if (strlen($_SESSION['sturecmsaid']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['submit'])) {
        $eid = $_GET['editid'];
    $stuid = $_POST['stuid'];
    $stuname = $_POST['stuname'];
    $stuclass = $_POST['stuclass'];
    $studob = $_POST['dob'];
    $stugender = $_POST['stugender'];
    $stuemail = $_POST['stuemail'];
    $stunumber = $_POST['stunumber'];
    $stuaddress = $_POST['stuaddress'];

    // Lấy dữ liệu quan hệ gia đình của sinh viên
    $stufather = $_POST['stufather'];
    $stumother = $_POST['stumother'];
    $stuguardian = $_POST['stuguardian'];
    $stuguanumber = $_POST['stuguanumber'];
    $stuguaaddress = $_POST['stuguaaddress'];

    // Lấy dữ liệu lịch sử lưu trú/ở trọ
    $stucca = $_POST['stucca'];
    $stucaddress = $_POST['stucaddress'];
    $stustartdate = $_POST['stustartdate'];
    $stuenddate = $_POST['stuenddate'];

    // Lấy dữ liệu tình hình bảo hiểm y tế của sinh viên
    $stuhic = $_POST['stuhic'];
    $stuhinsid = $_POST['stuhinsid'];
    $stuhinsstartyear = $_POST['stuhinsstartyear'];
    $stuhinsendyear = $_POST['stuhinsendyear'];
    $stuhinsdetail = $_POST['stuhinsdetail'];

    // Lấy dữ liệu giấy tờ nhập trường
    $chuyenSHDang = isset($_POST['chuyenSHDang']) ? $_POST['chuyenSHDang'] : 'thieu';
    $CNTotNghiepTT = isset($_POST['CNTotNghiepTT']) ? $_POST['CNTotNghiepTT'] : 'thieu';
    $CNKetQuaThiTT = isset($_POST['CNKetQuaThiTT']) ? $_POST['CNKetQuaThiTT'] : 'thieu';
    $HocBaTHPT = isset($_POST['HocBaTHPT']) ? $_POST['HocBaTHPT'] : 'thieu';
    $BangTHPT = isset($_POST['BangTHPT']) ? $_POST['BangTHPT'] : 'thieu';
    $CNKetQuaThi = isset($_POST['CNKetQuaThi']) ? $_POST['CNKetQuaThi'] : 'thieu';
    $CCCD = isset($_POST['CCCD']) ? $_POST['CCCD'] : 'thieu';
    $KhaiSinh = isset($_POST['KhaiSinh']) ? $_POST['KhaiSinh'] : 'thieu'; // sửa tên biến
    $Pic2x4 = isset($_POST['Pic2x4']) ? $_POST['Pic2x4'] : 'thieu';
    $SYLL = isset($_POST['SYLL']) ? $_POST['SYLL'] : 'thieu';
    $PhieuDKTuyen = isset($_POST['PhieuDKTuyen']) ? $_POST['PhieuDKTuyen'] : 'thieu';
    $ChuyenNVQS = isset($_POST['ChuyenNVQS']) ? $_POST['ChuyenNVQS'] : 'thieu';
    $XNUuTien = isset($_POST['XNUuTien']) ? $_POST['XNUuTien'] : 'thieu';
    $BaoNhapHoc = isset($_POST['BaoNhapHoc']) ? $_POST['BaoNhapHoc'] : 'thieu';


    // Thêm dữ liệu vào bảng sinh viên
    $sql = "UPDATE tblstudents SET StudentID = :stuid, StudentName = :stuname, StudentClass = :stuclass, DOB = :studob, Gender = :stugender, StudentEmail = :stuemail, ContactNumber = :stunumber, Address = :stuaddress WHERE ID = $eid";


$query = $dbh->prepare($sql);
$query->bindParam(':stuid', $stuid, PDO::PARAM_STR);
$query->bindParam(':stuname', $stuname, PDO::PARAM_STR);
$query->bindParam(':stuclass', $stuclass, PDO::PARAM_STR);
$query->bindParam(':studob', $studob, PDO::PARAM_STR);
$query->bindParam(':stugender', $stugender, PDO::PARAM_STR);
$query->bindParam(':stuemail', $stuemail, PDO::PARAM_STR);
$query->bindParam(':stunumber', $stunumber, PDO::PARAM_STR);
$query->bindParam(':stuaddress', $stuaddress, PDO::PARAM_STR);
$query->execute();

// Thêm dữ liệu vào bảng gia đình
$sql_family = "UPDATE tblfamily SET StudentID=:stuid, FatherName = :stufather, MotherName = :stumother, GuardianName = :stuguardian, GuardianNumber = :stuguanumber, GuardianAddress = :stuguaaddress WHERE ID = $eid";


$query_family = $dbh->prepare($sql_family);
$query_family->bindParam(':stuid', $stuid, PDO::PARAM_STR);
$query_family->bindParam(':stufather', $stufather, PDO::PARAM_STR);
$query_family->bindParam(':stumother', $stumother, PDO::PARAM_STR);
$query_family->bindParam(':stuguardian', $stuguardian, PDO::PARAM_STR);
$query_family->bindParam(':stuguanumber', $stuguanumber, PDO::PARAM_STR);
$query_family->bindParam(':stuguaaddress', $stuguaaddress, PDO::PARAM_STR);
$query_family->execute();

// Thêm dữ liệu vào bảng lịch sử lưu trú
$sql_residence = "UPDATE tblresidence SET StudentID=:stuid, ChooseCurrentAddress = :stucca, CurrentAddress = :stucaddress, StartDate = :stustartdate, EndDate = :stuenddate WHERE ID = $eid";


$query_residence = $dbh->prepare($sql_residence);
$query_residence->bindParam(':stuid', $stuid, PDO::PARAM_STR);
$query_residence->bindParam(':stucca', $stucca, PDO::PARAM_STR);
$query_residence->bindParam(':stucaddress', $stucaddress, PDO::PARAM_STR);
$query_residence->bindParam(':stustartdate', $stustartdate, PDO::PARAM_STR);
$query_residence->bindParam(':stuenddate', $stuenddate, PDO::PARAM_STR);
$query_residence->execute();

// Thêm dữ liệu vào bảng bảo hiểm y tế
$sql_health_insurance = "UPDATE tblhealthinsurance SET StudentID=:stuid, ChooseHealthInsurance = :stuhic, HealthInsuranceID = :stuhinsid, StartYear = :stuhinsstartyear, EndYear = :stuhinsendyear, Details = :stuhinsdetail WHERE ID = $eid";


$query_health_insurance = $dbh->prepare($sql_health_insurance);
$query_health_insurance->bindParam(':stuid', $stuid, PDO::PARAM_STR);
$query_health_insurance->bindParam(':stuhic', $stuhic, PDO::PARAM_STR);
$query_health_insurance->bindParam(':stuhinsid', $stuhinsid, PDO::PARAM_STR);
$query_health_insurance->bindParam(':stuhinsstartyear', $stuhinsstartyear, PDO::PARAM_STR);
$query_health_insurance->bindParam(':stuhinsendyear', $stuhinsendyear, PDO::PARAM_STR);
$query_health_insurance->bindParam(':stuhinsdetail', $stuhinsdetail, PDO::PARAM_STR);
$query_health_insurance->execute();

// Thêm dữ liệu vào bảng giấy tờ nhập trường


$sql_documents = "UPDATE tbldocuments SET 
    StudentID=:stuid,
    ChSHDang=:chuyenSHDang, 
    PrvCefHS=:CNTotNghiepTT, 
    PrvCefGradeHS=:CNKetQuaThiTT,
    HSAcademicRec=:HocBaTHPT, 
    CefHS=:BangTHPT, 
    CefUniExam=:CNKetQuaThi, 
    CitizenId=:CCCD,
    BirthCef=:KhaiSinh,
    Pic2x4=:Pic2x4, 
    StuCV=:SYLL,
    EnrollmentSlip=:PhieuDKTuyen, 
    ChuyenNVQS=:ChuyenNVQS, 
    CefPrio=:XNUuTien, 
    AdmissionNotice=:BaoNhapHoc 
WHERE ID = $eid";

$query_documents = $dbh->prepare($sql_documents);
$query_documents->bindParam(':stuid', $stuid, PDO::PARAM_STR);
$query_documents->bindParam(':chuyenSHDang', $chuyenSHDang, PDO::PARAM_STR);
$query_documents->bindParam(':CNTotNghiepTT', $CNTotNghiepTT, PDO::PARAM_STR);
$query_documents->bindParam(':CNKetQuaThiTT', $CNKetQuaThiTT, PDO::PARAM_STR);
$query_documents->bindParam(':HocBaTHPT', $HocBaTHPT, PDO::PARAM_STR);
$query_documents->bindParam(':BangTHPT', $BangTHPT, PDO::PARAM_STR);
$query_documents->bindParam(':CNKetQuaThi', $CNKetQuaThi, PDO::PARAM_STR);
$query_documents->bindParam(':CCCD', $CCCD, PDO::PARAM_STR);
$query_documents->bindParam(':KhaiSinh', $KhaiSinh, PDO::PARAM_STR);
$query_documents->bindParam(':Pic2x4', $Pic2x4, PDO::PARAM_STR);
$query_documents->bindParam(':SYLL', $SYLL, PDO::PARAM_STR);
$query_documents->bindParam(':PhieuDKTuyen', $PhieuDKTuyen, PDO::PARAM_STR);
$query_documents->bindParam(':ChuyenNVQS', $ChuyenNVQS, PDO::PARAM_STR);
$query_documents->bindParam(':XNUuTien', $XNUuTien, PDO::PARAM_STR);
$query_documents->bindParam(':BaoNhapHoc', $BaoNhapHoc, PDO::PARAM_STR);

$query_documents->execute();
  echo '<script>alert("Thông tin sinh viên đã được cập nhập!")</script>';
}

  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>QL HSSV - Cập nhật sinh viên</title>

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
                        <h3 class="page-title"> Cập nhật thông tin sinh viên </h3>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page"> Cập nhật</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title" style="text-align: center;">Nhập thông tin</h4>
                                    <form class="forms-sample" method="post" enctype="multipart/form-data">
                                    <?php
$eid=$_GET['editid'];
$sql = "SELECT 
            tblstudents.StudentName,
            tblstudents.StudentEmail,
            tblstudents.StudentClass,
            tblstudents.Gender,
            tblstudents.DOB,
            tblstudents.StudentID,
            tblstudents.ContactNumber,
            tblstudents.Address,

            tblfamily.FatherName,
            tblfamily.MotherName,
            tblfamily.GuardianName,
            tblfamily.GuardianNumber,
            tblfamily.GuardianAddress,

            tbldocuments.ChSHDang,
            tbldocuments.PrvCefHS,
            tbldocuments.PrvCefGradeHS,
            tbldocuments.HSAcademicRec,
            tbldocuments.CefHS,
            tbldocuments.EnrollmentSlip,
            tbldocuments.ChuyenNVQS,
            tbldocuments.CefUniExam,
            tbldocuments.CitizenID,
            tbldocuments.BirthCef,
            tbldocuments.Pic2x4,
            tbldocuments.StuCV,
            tbldocuments.CefPrio,
            tbldocuments.AdmissionNotice,

            tblresidence.StudentID,
            tblresidence.ChooseCurrentAddress,
            tblresidence.CurrentAddress,
            tblresidence.StartDate,
            tblresidence.EndDate,

            tblhealthinsurance.ChooseHealthInsurance,
            tblhealthinsurance.HealthInsuranceID,
            tblhealthinsurance.StartYear,
            tblhealthinsurance.EndYear,
            tblhealthinsurance.Details,

            tblclass.ClassName
        FROM 
            tblstudents
        JOIN 
            tblclass ON tblclass.ID = tblstudents.StudentClass
        Inner JOIN 
            tblfamily ON tblfamily.ID = tblstudents.ID
        Inner JOIN 
            tbldocuments ON tbldocuments.ID = tblstudents.ID
        Inner JOIN
            tblresidence ON tblresidence.ID = tblstudents.ID
        Inner JOIN
            tblhealthinsurance ON tblhealthinsurance.ID = tblstudents.ID

        WHERE 
            tblstudents.ID = :eid";

$query = $dbh->prepare($sql);
$query->bindParam(':eid', $eid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                                        <!-- Thông tin sinh viên -->
                                        <div class="form-group">
                                            <label for="exampleInputName1">Mã sinh viên</label>
                                            <input type="text" name="stuid" value="<?php  echo htmlentities($row->StudentID);?>" class="form-control" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputName1">Họ tên sinh viên</label>
                                            <input type="text" name="stuname" value="<?php  echo htmlentities($row->StudentName);?>" class="form-control" required='true'>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail3">Lớp học</label>
                                            <select  name="stuclass" class="form-control" required='true'>
                                            <option value="<?php echo htmlentities($row->StudentClass);?>">
                                            <?php echo htmlentities($row->ClassName );?>
                                          </option>
                                                <?php 
                                                    $sql2 = "SELECT * FROM tblclass";
                                                    $query2 = $dbh->prepare($sql2);
                                                    $query2->execute();
                                                    $result2 = $query2->fetchAll(PDO::FETCH_OBJ);

                                                    foreach($result2 as $row1) { ?>  
                                                        <option value="<?php echo htmlentities($row1->ID);?>">
                                                            <?php echo htmlentities($row1->ClassName);?>
                                                        </option>
                                                <?php } ?> 
                                            </select>
                                        </div>
                                        <div class="form-group">
                        <label for="exampleInputName1">Ngày sinh</label>
                        <input type="date" name="dob" value="<?php  echo htmlentities($row->DOB);?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Giới tính</label>
                        <select name="stugender" value="" class="form-control" required='true'>
                          <option value="<?php  echo htmlentities($row->Gender);?>"><?php  echo htmlentities($row->Gender);?></option>
                          <option value="Nam">Nam</option>
                          <option value="Nữ">Nữ</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Email</label>
                        <input type="text" name="stuemail" value="<?php echo htmlentities($row->StudentEmail)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Số điện thoại</label>
                        <input type="number" name="stunumber" value="<?php echo htmlentities($row->ContactNumber)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Nơi thường trú</Address></label>
                        <input type="text" name="stuaddress" value="<?php echo htmlentities($row->Address)?>" class="form-control" required='true'>
                      </div>
                                         <!-- Thông tin gia đình sinh viên -->                   
                      <h3>Cha mẹ, người giám hộ sinh viên</h3>
                      <div class="form-group">
                        <label for="exampleInputName1">Họ tên cha</label>
                        <input type="text" name="stufather" value="<?php echo htmlentities($row->FatherName)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Họ tên mẹ</label>
                        <input type="text" name="stumother" value="<?php echo htmlentities($row->MotherName)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Người giám hộ</label>
                        <input type="text" name="stuguardian" value="<?php echo htmlentities($row->GuardianName)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Số liên lạc </label>
                        <input type="text" name="stuguanumber" value="<?php echo htmlentities($row->GuardianNumber)?>" class="form-control" required='true' maxlength="10" pattern="[0-9]+">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1"> Địa chỉ cha mẹ hoặc người giám hộ</label>
                        <textarea name="stuguaaddress" class="form-control" required='true'><?php echo htmlentities($row->GuardianAddress)?></textarea>                      </div>
                                        <!-- Thông tin lịch sử lưu trú -->
                                        <h3>Lịch sử lưu trú</h3>
                        <div class="form-group">
                        <label for="exampleInputName1">Chọn nơi ở</label>
                        <select name="stucca" value="" class="form-control" required='true'>
                          <?php 
                           $currentAddress = htmlentities($row->ChooseCurrentAddress);

                           switch ($currentAddress) {
                               case 'home':
                                   $displayText = 'Nhà';
                                   break;
                               case 'inn':
                                   $displayText = 'Nhà trọ';
                                   break;
                               case 'ktx':
                                   $displayText = 'Ký túc xá';
                                   break;
                               case 'ot':
                                   $displayText = 'Khác';
                                   break;
                               default:
                                   $displayText = '--Chọn nơi ở--';
                                   break;
                           }
                          ?>
                          <option value="<?php echo $currentAddress; ?>"><?php echo $displayText; ?></option>
                          <option value="home">Nhà</option>
                          <option value="inn">Nhà trọ</option>
                          <option value="ktx">Ký túc xá</option>
                          <option value="ot">Khác</option>
                        </select>
                      </div>              
                      <div class="form-group">
                        <label for="exampleInputName1">Địa chỉ</label>
                        <input type="text" name="stucaddress" value="<?php echo htmlentities($row->CurrentAddress)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Ngày bắt đầu</label>
                        <input type="date" name="stustartdate" value="<?php echo htmlentities($row->StartDate)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Ngày kết thúc</label>
                        <input type="date" name="stuenddate" value="<?php echo htmlentities($row->EndDate)?>" class="form-control" required='false' maxlength="10" pattern="[0-9]+">
                      </div> 
                                
                                        <!-- Thông tin bảo hiểm y tế -->    
                                        <h3>Bảo hiểm y tế</h3>
                        <div class="form-group">
                        <label for="exampleInputName1">Chọn nơi thực hiện bảo hiểm y tế</label>
                        <select name="stuhic" class="form-control" required='true'>
                            <?php 
                            $currentHealthPlan = htmlentities($row->ChooseHealthInsurance);

                            switch ($currentHealthPlan) {
                                case 'home':
                                    $displayText2 = 'Nhà';
                                    break;
                                case 'school':
                                    $displayText2 = 'Trường';
                                    break;
                                case 'ot':
                                    $displayText2 = 'Khác';
                                    break;
                                default:
                                    $displayText2 = '--Chọn nơi ở--';
                                    break;
                            }
                            ?>
                            <option value="<?php echo $currentHealthPlan; ?>"><?php echo $displayText2; ?></option>
                            <option value="home">Nhà</option>
                            <option value="school">Trường</option>
                            <option value="ot">Khác</option>
                        </select>
                      </div>              
                      <div class="form-group">
                        <label for="exampleInputName1">Mã bảo hiểm y tế</label>
                        <input type="text" name="stuhinsid" value="<?php echo htmlentities($row->HealthInsuranceID)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Ngày bắt đầu</label>
                        <input type="date" name="stuhinsstartyear" value="<?php echo htmlentities($row->StartYear)?>" class="form-control" required='true'>
                      </div>
                      <div class="form-group">
                        <label for="exampleInputName1">Ngày kết thúc</label>
                        <input type="date" name="stuhinsendyear" value="<?php echo htmlentities($row->EndYear)?>" class="form-control" required='false' maxlength="10" pattern="[0-9]+">
                      </div> 
                      <div class="form-group">
                        <label for="exampleInputName1">Ghi chú</label>
                        <input type="text" name="stuhinsdetail" value="<?php echo htmlentities($row->Details)?>" class="form-control" required='true'>
                      </div>              
                                         
                                         <!-- Thông tin giấy tờ nhập trường -->
<div class="row">
<script>
    $('doc').change(function() {
    if(this.checked) {
        this.value = 'Đã nộp';
    } else {
        this.value = 'Thiếu';
    }
});
</script>

        <div class="col-md-6">
            <label><input type="checkbox" id="doc" name="chuyenSHDang" value="" <?php echo ($row->ChSHDang == 'Đã nộp') ? 'checked' : ''; ?>> Giấy chuyển sinh hoạt Đảng hoặc đoàn (nếu có)</label><br>
            <label><input type="checkbox" id="doc" name="CNTotNghiepTT" value="" <?php echo ($row->PrvCefHS == 'Đã nộp') ? 'checked' : ''; ?>> Giấy chứng nhận tốt nghiệp THPT tạm thời</label><br>
            <label><input type="checkbox" id="doc" name="CNKetQuaThiTT" value="" <?php echo ($row->PrvCefGradeHS == 'Đã nộp') ? 'checked' : ''; ?> > Giấy chứng nhận kết quả thi tốt nghiệp THPT năm 2021 (bản gốc)</label><br>
            <label><input type="checkbox" id="doc" name="HocBaTHPT" value="" <?php echo ($row->HSAcademicRec == 'Đã nộp') ? 'checked' : ''; ?>> Học bạ THPT hoặc tương đương (bản sao công chứng)</label><br>
            <label><input type="checkbox" id="doc" name="BangTHPT" value="" <?php echo ($row->CefHS == 'Đã nộp') ? 'checked' : ''; ?>> Bằng tốt nghiệp cấp 3 (photo công chứng)</label><br>
        </div>
        <div class="col-md-6">
            <label><input type="checkbox" id="doc" name="CNKetQuaThi" value="" <?php echo ($row->CefUniExam == 'Đã nộp') ? 'checked' : ''; ?>> Giấy chứng nhận kết quả thi</label><br>
            <label><input type="checkbox" id="doc" name="CCCD" value="" <?php echo ($row->CitizenID == 'Đã nộp') ? 'checked' : ''; ?>> Bản photo công chứng CMND hoặc Căn cước công dân</label><br>
            <label><input type="checkbox" id="doc" name="KhaiSinh" value="" <?php echo ($row->BirthCef == 'Đã nộp') ? 'checked' : ''; ?>> Giấy khai sinh (bản sao hoặc trích lục)</label><br>
            <label><input type="checkbox" id="doc" name="Pic2x4" value="" <?php echo ($row->Pic2x4 == 'Đã nộp') ? 'checked' : ''; ?>> 2 ảnh 3*4</label><br>
            <label><input type="checkbox" id="doc" name="SYLL" value=""> Sơ yếu lý lịch (có dấu xác nhận của địa phương)</label><br>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <label><input type="checkbox" id="doc" name="PhieuDKTuyen" value="" <?php echo ($row->EnrollmentSlip == 'Đã nộp') ? 'checked' : ''; ?>> Phiếu đăng ký xét tuyển</label><br>
            <label><input type="checkbox" id="doc" name="ChuyenNVQS" value="" <?php echo ($row->ChuyenNVQS == 'Đã nộp') ? 'checked' : ''; ?>> Giấy chuyển NVQS</label><br>
        </div>
        <div class="col-md-6">
            <label><input type="checkbox" id="doc" name="XNUuTien" value="" <?php echo ($row->CefPrio == 'Đã nộp') ? 'checked' : ''; ?>> Các loại giấy tờ xác nhận đối tượng và khu vực ưu tiên (nếu có)</label><br>
            <label><input type="checkbox" id="doc" name="BaoNhapHoc" value="" <?php echo ($row->AdmissionNotice == 'Đã nộp') ? 'checked' : ''; ?>> Giấy báo nhập học hoặc thông báo xác nhận xét tuyển (bản chính)</label><br>
        </div>
    </div><?php $cnt=$cnt+1;}} ?>


                                        <button type="submit" class="btn btn-primary mt-1 mr-2 " name="submit">Lưu</button>
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
</html><?php }  ?>