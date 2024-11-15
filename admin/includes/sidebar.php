<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="images/faces/face8.jpg" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                  <?php
         $aid= $_SESSION['sturecmsaid'];
$sql="SELECT * from tbladmin where ID=:aid";

$query = $dbh -> prepare($sql);
$query->bindParam(':aid',$aid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $row)
{               ?>
                  <p class="profile-name"><?php  echo htmlentities($row->AdminName);?></p>
                  <p class="designation"><?php  echo htmlentities($row->Email);?></p><?php $cnt=$cnt+1;}} ?>
                </div>
               
              </a>
            </li>
            <li class="nav-item nav-category">
              <span class="nav-link">Quản lý hồ sơ sinh viên</span>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="dashboard.php">
                <span class="menu-title">Báo cáo thống kê</span>
                <i class="icon-screen-desktop menu-icon"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <span class="menu-title">Quản lý khoa</span>
                <i class="icon-layers menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-faculty.php">Thêm khoa</a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-faculty.php">Thông tin khoa</a></li>
                  <li class="nav-item"> <a class="nav-link" href="of-majors-of-faculty.php">Ngành của khoa</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic1">
                <span class="menu-title">Quản lý ngành học</span>
                <i class="icon-layers menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-major.php">Thêm ngành</a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-major.php">Thông tin ngành</a></li>
                  <li class="nav-item"> <a class="nav-link" href="of-classes-of-major.php">Lớp của ngành</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic2">
                <span class="menu-title">Quản lý lớp học</span>
                <i class="icon-layers menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic2">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-class.php">Thêm lớp</a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-class.php">Thông tin lớp</a></li>
                  <li class="nav-item"> <a class="nav-link" href="of-students-of-class.php">Sinh viên của lớp</a></li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#ui-basic3" aria-expanded="false" aria-controls="ui-basic3">
                <span class="menu-title">Quản lý sinh viên</span>
                <i class="icon-people menu-icon"></i>
              </a>
              <div class="collapse" id="ui-basic3">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item"> <a class="nav-link" href="add-colleaguestudents.php">Thêm sinh viên</a></li>
                  <li class="nav-item"> <a class="nav-link" href="manage-students.php">Thông tin sinh viên</a></li>
                  <li class="nav-item"> <a class="nav-link" href="show-student-inn.php">Tình hình ở trọ</a></li>
                  <li class="nav-item"> <a class="nav-link" href="show-student-hi.php">Tình hình tham gia bhyt</a></li>
                  <li class="nav-item"> <a class="nav-link" href="show-student-doc.php">Tình hình hồ sơ sinh viên</a></li>
                </ul>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="search.php">
                <span class="menu-title">Tìm kiếm</span>
                <i class="icon-magnifier menu-icon"></i>
              </a>
            </li>
            </li>
          </ul>
        </nav>