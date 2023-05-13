<?php
session_start();
$conn = mysqli_connect("localhost","root","","TimeTableProject");
$year = $_POST['year'];
$divison = $_POST['division'];
// echo $year,$divison;
$sql = "select * from Classes where UPPER(Year) like UPPER('$year%') and UPPER(Division) like UPPER('$divison%')";

$result = mysqli_query($conn, $sql);
while($row=mysqli_fetch_array($result))
    echo '<button class="custom_button primary-btn" onClick="generatePDF('.$row['id'].')">'.$row['Year'].' '.$row['Division'].'</button>';


?>