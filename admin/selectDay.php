<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Day</title>
		<link rel="stylesheet" href="./styles.css" />
</head>
<body>
	<a  class='primary-btn logout' href="./logout.php">Logout</a>
<div class="container">
		<ul>
				<li class="nav-item"><a href="../student/student_home.php" class='text-dec-none'> Home </a></li>
				<li class="nav-item"><a href="./home.php" class='text-dec-none'> Admin </a></li>
			</ul>
		</div>
        <?php
            session_start();
            if(!isset($_SESSION['admin'])){
                header("Location: ./login.php");
                exit();
            }
            // echo "Welcome, ".$_SESSION['admin'];
            
        ?>
		<div class='grid-center'>
        <div class="master-box">
            <h1 class="txt-align-center txt-white">Select Day</h1>
            <div class="center-align-container">
                <a href="./createTimeTable.php?day=Monday&class=<?php echo $_GET['class']; ?>" class="primary-btn">Monday</a>
                <a href="./createTimeTable.php?day=Tuesday&class=<?php echo $_GET['class']; ?>" class="primary-btn">Tuesday</a>
                <a href="./createTimeTable.php?day=Wednesday&class=<?php echo $_GET['class']; ?>" class="primary-btn">Wednesday</a>
                <a href="./createTimeTable.php?day=Thursday&class=<?php echo $_GET['class']; ?>" class="primary-btn">Thursday</a>
                <a href="./createTimeTable.php?day=Friday&class=<?php echo $_GET['class']; ?>" class="primary-btn">Friday</a>
            </div>
        </div>
    </div>
</body>
</html>