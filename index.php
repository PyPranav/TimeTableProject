
<?php
session_start();
if (isset($_SESSION['college_name'])) {
    header("Location: ./student/student_home.php");
    exit();
}
else {
    header("Location: ./student/select_college.php");
    exit();
}
?>
