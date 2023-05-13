<?php
session_start();
if (!isset($_SESSION['college_name'])) {
    header("Location: ./select_college.php");
}

echo $_POST['complain'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
    if($conn){
        // INSERT INTO `Complain` (`complain`, `sname`, `room_id`, `College_Name`, `complain_id`) VALUES ('fans not working', 'pssssss', '2', 'pce', NULL);
        $sql = "INSERT INTO `Complain` (`complain`, `sname`, `room_id`, `College_Name`) VALUES ('".$_POST['complain']."','".$_POST['sname']."','".$_POST['room_id']."','".$_SESSION['college_name']."')";
        echo $sql;
        $result = mysqli_query($conn,$sql);
    }
    header("Location: ./student_home.php");
?>