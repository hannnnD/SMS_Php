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
   
    <title>QL HSSV - Quản lý khoa</title>
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
              <h3 class="page-title"> Quản lý khoa </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page"> Quản lý khoa</li>
                </ol>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-sm-flex align-items-center mb-4">
                      <h4 class="card-title mb-sm-0">Quản lý khoa</h4>
                      <a href="#" class="text-dark ml-auto mb-3 mb-sm-0"> Xem tất cả khoa</a>
                    </div>
                    <div class="table-responsive border rounded p-1">
                      <table class="table">
                        <thead>
                          <tr>
                            <th class="font-weight-bold">STT</th>
                            <th class="font-weight-bold">Mã khoa</th>
                            <th class="font-weight-bold">Tên khoa</th>
                            <th class="font-weight-bold">Sửa||Xóa</th>
                          </tr>
                        </thead>
                        <tbody>

<?php
if (isset($_GET['pageno'])) {
$pageno = $_GET['pageno'];
} else {
 $pageno = 1;
}
$no_of_records_per_page =15;
$offset = ($pageno-1) * $no_of_records_per_page;
$ret = "SELECT ID FROM tblfaculty";
$query1 = $dbh -> prepare($ret);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);
$total_rows=$query1->rowCount();
$total_pages = ceil($total_rows / $no_of_records_per_page);
$sql="SELECT * from tblfaculty LIMIT $offset, $no_of_records_per_page";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               
?>   

                          <tr>
                            <td><?php echo htmlentities($cnt);?></td>
                            <td><?php  echo htmlentities($row->fid);?></td>
                            <td><?php  echo htmlentities($row->FacultyName);?></td>
                            <td>
                              <div><a href="edit-faculty-detail.php?editid=<?php echo htmlentities ($row->ID);?>"><i class="icon-eye"></i></a>||
                             <a href="manage-faculty.php?delid=<?php echo ($row->ID);?>
                             " onclick="return confirm('Bạn thực sự muốn xóa ?');"> <i class="icon-trash"></i></a></div>
                            </td> 
                          </tr><?php $cnt=$cnt+1;}} ?>
                        </tbody>
                      </table>
                    </div>
                    <div align="left">

    <ul class="pagination" >
        <li><a href="?pageno=1"><strong>Trang đầu></strong></a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>"><strong style="padding-left: 10px">Trang trước></strong></a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>"><strong style="padding-left: 10px">Trang sau></strong></a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>"><strong style="padding-left: 10px">Trang cuối</strong></a></li>
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