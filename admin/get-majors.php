<?php
session_start();
include('includes/dbconnection.php');

// Check if the faculty parameter is set
if(isset($_GET['faculty'])){
    $selectedFaculty = $_GET['faculty'];

    $sqlMajors = "SELECT MajorName FROM tblmajor WHERE fmid = :faculty";
    $queryMajors = $dbh->prepare($sqlMajors);
    $queryMajors->bindParam(':faculty', $selectedFaculty, PDO::PARAM_STR);
    $queryMajors->execute();
    $majors = $queryMajors->fetchAll(PDO::FETCH_ASSOC);

    if(count($majors) > 0){
        // Output HTML table
        echo '<div class="table-responsive border rounded p-1">';
        echo '<table class="table">';
        echo '<thead><tr><th>STT</th><th>Tên ngành</th></tr></thead>';
        echo '<tbody>';
        $cnt = 1;
        foreach($majors as $major){
            echo '<tr>';
            echo '<td>' . $cnt . '</td>';
            echo '<td>' . $major['MajorName'] . '</td>';
            echo '</tr>';
            $cnt++;
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'Không có ngành học nào cho khoa được chọn.';
    }
} else {
    echo 'Không có dữ liệu được truyền đến.';
}
?>
