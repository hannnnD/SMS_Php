
<?php
session_start();
include('includes/dbconnection.php');

// Check if the major parameter is set
if (isset($_GET['class'])) {
    $selectedClass = $_GET['class'];

    // Assuming 'StudentClass' is the column in 'tblstudents' that stores the ID of the class
    $sql = "SELECT StudentID, StudentName, DOB, ContactNumber FROM tblstudents
            WHERE StudentClass = :class";

    $query = $dbh->prepare($sql);
    $query->bindParam(':class', $selectedClass, PDO::PARAM_STR);
    $query->execute();

    $students = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($students) > 0) {
        // Output HTML table
        echo '<div class="table-responsive border rounded p-1">';
        echo '<table class="table">';
        echo '<thead><tr><th>STT</th><th>Mã sinh viên</th><th>Tên sinh viên</th><th>Ngày sinh</th><th>Số điện thoại</th></tr></thead>';
        echo '<tbody>';
        $cnt = 1;
        foreach ($students as $student) {
            echo '<tr>';
            echo '<td>' . $cnt . '</td>';
            echo '<td>' . $student['StudentID'] . '</td>';
            echo '<td>' . $student['StudentName'] . '</td>';
            echo '<td>' . $student['DOB'] . '</td>';
            echo '<td>' . $student['ContactNumber'] . '</td>';
            echo '</tr>';
            $cnt++;
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'Không có sinh viên nào cho lớp được chọn.';
    }
} else {
    echo 'Không có dữ liệu được truyền đến.';
}
?>
