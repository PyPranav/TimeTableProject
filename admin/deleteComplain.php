<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);

$toDelete = $data['deleteId'];
$conn = mysqli_connect("localhost","root","","TimeTableProject");
if($conn){
    foreach($toDelete as $delID){
        $sql = "delete from Complain where complain_id=".$delID;
        $result = mysqli_query($conn,$sql);
    }
}
?>