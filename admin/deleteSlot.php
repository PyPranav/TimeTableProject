<?php
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
    if($conn){
        $sql = 'delete from Slots where slot_id = '.$_GET["slot_id"];
        
        echo $sql;
        $result = mysqli_query($conn,$sql);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }
?>