<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$toDelete = $data['deleteId'];
$toInsert = $data['classroomData'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
echo 'ffff';
function nameStrip($v)
{
    return $v['tname'];
}
if($conn){
    foreach($toDelete as $delID){
        $sql = "delete from Classrooms where Room_id=".$delID;
        echo 'idk'.$classroom['name'].'idk '.$sql;
        $result = mysqli_query($conn,$sql);
    }
    $result = mysqli_query($conn,'select * from Classrooms where College_name = "'.$_SESSION['admin'].'"');
    $allClassroom = array_map('nameStrip', mysqli_fetch_all($result, MYSQLI_ASSOC));
    foreach($toInsert as $classroom){
        // if(in_array($classroom['tname'],$allclassroom)){
            
        //     echo $classroom['name'];
        //     continue;
        // }
        if($classroom['Room_id']!='' && $classroom['isLab']!=''){
            if((int)$classroom['Room_id']<0) $sql = "INSERT INTO `Classrooms`(`Room_no`, `isLab`, `college_name`) VALUES('".$classroom['Room_no']."','".$classroom['isLab']."','".$_SESSION['admin']."')";
            else {$sql = "update Classrooms set Room_no='".$classroom['Room_no']."', isLab=".$classroom['isLab']." where Room_id=".$classroom['Room_id'];
            echo 'idk'.$classroom['name'].'idk '.$sql;}
            $result = mysqli_query($conn,$sql);
        }
    }
}

?>