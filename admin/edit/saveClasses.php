<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$toDelete = $data['deleteId'];
$toInsert = $data['classesData'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
// echo 'ffff';
function nameStrip($v)
{
    return $v['Year']." ".$v['Division'];
}
if($conn){
    foreach($toDelete as $delID){
        $sql = "delete from Classes where id=".$delID;
        $result = mysqli_query($conn,$sql);
    }
    $result = mysqli_query($conn,'select * from Classes where College_name = "'.$_SESSION['admin'].'"');
    $allClasses = array_map('nameStrip', mysqli_fetch_all($result, MYSQLI_ASSOC));
    foreach($toInsert as $classes){
        if(in_array($classes['Year']." ".$classes['Division'],$allClasses)){
            
            // echo $classes['name'];
            continue;
        }
        if($classes['Year']!='' && $classes['Division']!=''){
            $sql = "INSERT INTO `Classes`(`Year`, `Division`, `College_name`) VALUES('".$classes['Year']."','".$classes['Division']."','".$_SESSION['admin']."')";
            // echo 'idk'.$classes['name'].'idk '.$sql;
            $result = mysqli_query($conn,$sql);
        }
    }
}

?>