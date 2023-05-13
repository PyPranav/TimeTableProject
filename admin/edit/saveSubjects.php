<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$toDelete = $data['deleteId'];
$toInsert = $data['subjectData'];
$toEdit = $data['editList'];
$editId = $data['editId'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
echo 'ffff';
function nameStrip($v)
{

return $v['sname'];
}
if($conn){
    foreach($toDelete as $delID){
        
        $sql = "delete from Subject where id=".$delID;
        $result = mysqli_query($conn,$sql);
    }
    foreach($toEdit as $data){
        $sql = "update Subject set sname='".$data['sname']."', normalDuration=".$data['normalDuration'].", isLab=".$data['isLab'].", labDuration=".$data['labDuration']." where id=".$data['id'];
        $result = mysqli_query($conn,$sql);
    }
    $result = mysqli_query($conn,'select sname from Subject where college_name = "'.$_SESSION['admin'].'"');
    $allSubject = array_map('nameStrip', mysqli_fetch_all($result, MYSQLI_ASSOC));
    foreach($toInsert as $subject){
        if(in_array($subject['sname'],$allSubject) or in_array($subject['id'],$editId)){
            
            echo $subject['sname'];
            continue;
        }
        if($subject['sname']!='' && $subject['normalDuration']!='' && $subject['isLab']!='' && $subject['labDuration']!=''){
            $sql = "insert into Subject (sname, normalDuration, isLab, labDuration, college_name) values('".$subject['sname']."',".$subject['normalDuration'].",".$subject['isLab'].",".$subject['labDuration'].",'".$_SESSION['admin']."')";
            // echo 'idk'.$subject['sname'].'idk '.$sql;
            $result = mysqli_query($conn,$sql);
        }
    }
}

?>