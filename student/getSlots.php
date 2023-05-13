<?php
session_start();
$conn = mysqli_connect("localhost","root","","TimeTableProject");
$id = $_POST['id'];
// echo $id;
$days = ['Monday','Tuesday','Wednesday','Thursday','Friday'];
foreach($days as $day){
    $sql = "select * from Slots inner join Subject on Slots.subject_id = Subject.id inner join Teachers on Slots.teacher_id = Teachers.tid inner join Classrooms on Slots.classroom_id = Classrooms.Room_id where class_id = $id and day = '$day'  order by startTime";
    $result = mysqli_query($conn, $sql);
    $li = array();
    while($row=mysqli_fetch_array($result)){

        array_push($li,$row);
    }
    echo json_encode($li);
    echo " gap_here ";
}
?>