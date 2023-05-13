<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$toDelete = $data['deleteId'];
$toInsert = $data['teacherData'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
// echo 'ffff';
function nameStrip($v)
{
    return $v['tname'];
}
if($conn){
    foreach($toDelete as $delID){
        $sql = "delete from Teachers where tid=".$delID;
        // echo 'idk'.$teacher['name'].'idk '.$sql;
        $result = mysqli_query($conn,$sql);
    }
    $result = mysqli_query($conn,'select * from Teachers where College_name = "'.$_SESSION['admin'].'"');
    $allTeacher = array_map('nameStrip', mysqli_fetch_all($result, MYSQLI_ASSOC));
    foreach($toInsert as $teacher){
        // if(in_array($teacher['tname'],$allteacher)){
            
        //     echo $teacher['name'];
        //     continue;
        // }
        if($teacher['tname']!='' && $teacher['subject_id']!=''){
            if((int)$teacher['id']<0) $sql = "INSERT INTO `Teachers`(`tname`, `subject_id`, `College_name`) VALUES('".$teacher['tname']."','".$teacher['subject_id']."','".$_SESSION['admin']."')";
            else {$sql = "update Teachers set tname='".$teacher['tname']."', subject_id=".$teacher['subject_id']." where tid=".$teacher['tid'];
            // echo 'idk'.$teacher['name'].'idk '.$sql;
        }
            $result = mysqli_query($conn,$sql);
        }
    }
    echo 'Data Saved!!';
}

?>