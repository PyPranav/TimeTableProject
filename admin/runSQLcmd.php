<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$querry = $data['q'];
$appendUser = $data['appendUser'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
if($conn){
    $sql = "select * from Slots where college_name = '".$_SESSION['admin']."' and day='".$data['day']."' and class_id = '".$data['classId']."';";
    $result = mysqli_query($conn,$sql);
    // echo mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result)) {
        if((strtotime($row['startTime']) <= strtotime($data['start-time']) && strtotime(($row['endTime'])) > strtotime($data['start-time']) )|| (strtotime($row['startTime'] )< strtotime($data['end-time']) && strtotime( $row['endTime']) >= strtotime($data['end-time']))){
            echo "Slot already exists!";
            return;
        }
    }

    $sql = "select * from Slots inner join Subject on Slots.subject_id = Subject.id where Slots.college_name = '".$_SESSION['admin']."' and Slots.teacher_id = '".$data['teacher']."' and Slots.day='".$data['day']."';";
    $result = mysqli_query($conn,$sql);
    // echo mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result)) {
        if($row['sname'] == "BREAK")
            continue;
        if((strtotime($row['startTime']) <= strtotime($data['start-time']) && strtotime(($row['endTime'])) > strtotime($data['start-time']) )|| (strtotime($row['startTime'] )< strtotime($data['end-time']) && strtotime( $row['endTime']) >= strtotime($data['end-time']))){
            echo "The teacher is busy!";
            return;
        }
    }

    $sql = "select * from Slots where Slots.college_name = '".$_SESSION['admin']."' and Slots.classroom_id = '".$data['classroom']."' and Slots.day='".$data['day']."';";
    $result = mysqli_query($conn,$sql);
    // echo mysqli_num_rows($result);
    while($row = mysqli_fetch_array($result)) {
        if((strtotime($row['startTime']) <= strtotime($data['start-time']) && strtotime(($row['endTime'])) > strtotime($data['start-time']) )|| (strtotime($row['startTime'] )< strtotime($data['end-time']) && strtotime( $row['endTime']) >= strtotime($data['end-time']))){
            echo "Classroom already occupied!";
            return;
        }
    }


    $sql = $querry.",'".$_SESSION['admin']."')";
    $result = mysqli_query($conn,$sql);

    echo "Data Saved!";
}
?>