<?php
session_start();
include('includes/dbconnection.php');

// Check if the faculty parameter is set
if(isset($_GET['major'])){
    $selectedMajor = $_GET['major'];

    // Explicitly set the collation in the query
    $sqlClasses = "SELECT ClassName FROM tblclass WHERE mcname = :major COLLATE utf8_general_ci";
    $queryClasses = $dbh->prepare($sqlClasses);
    $queryClasses->bindParam(':major', $selectedMajor, PDO::PARAM_STR);
    $queryClasses->execute();
    $classes = $queryClasses->fetchAll(PDO::FETCH_ASSOC);

    if(count($classes) > 0){
        // Output HTML table
        echo '<div class="table-responsive border rounded p-1">';
        echo '<table class="table">';
        echo '<thead><tr><th>STT</th><th>Tên lớp học</th></tr></thead>';
        echo '<tbody>';
        $cnt = 1;
        foreach($classes as $class){
            echo '<tr>';
            echo '<td>' . $cnt . '</td>';
            echo '<td>' . $class['ClassName'] . '</td>';
            echo '</tr>';
            $cnt++;
        }
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo 'Không có lớp học nào cho ngành được chọn.';
    }
} else {
    echo 'Không có dữ liệu được truyền đến.';
}
?>
