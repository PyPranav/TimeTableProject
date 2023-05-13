

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Admin</title>
		<link rel="stylesheet" href="./styles.css" />
		<script>
			const classesData = []
			const onSearch = () => {
				const search = document.querySelector('input').value.toUpperCase()
				const table = document.querySelector('.table-container')
				table.innerHTML = ''
				classesData.forEach((classData) => {
					if (classData.Year.toUpperCase().includes(search) || classData.Division.toUpperCase().includes(search) || (classData.Year+" "+classData.Division).toUpperCase().includes(search)) {
						table.innerHTML += `<button class='primary-btn m-10'>${classData.Year} ${classData.Division}</button>`
					}
				})
			}
		</script>
	</head>
	<body>
	<a  class='primary-btn logout' href="./logout.php">Logout</a>
		<div class="container">
		<ul>
				<li class="nav-item"><a href="../student/student_home.php" class='text-dec-none'> Home </a></li>
				<li class="nav-item"><a href="" class='text-dec-none'> Admin </a></li>
			</ul>
		</div>
        <?php
            session_start();
            if(!isset($_SESSION['admin'])){
                header("Location: ./login.php");
                exit();
            }
			
        ?>
		<div class='grid-center'>
			<div class="master-box">
				<div class="right-align-container p-20">
					<a  class='primary-btn' href="./edit/subjects.php">Edit Subjects</a>
					<a  class='primary-btn'  href="./edit/classes.php">Edit Classes</a>

					<a  class='primary-btn'  href="./complains.php">Complains</a>
				</div>
				<div class="right-align-container" style='padding-right:20px;'>

				<a  class='primary-btn' href="./edit/teachers.php">Edit Teachers</a>
					<a  class='primary-btn' href="./edit/classrooms.php">Edit Classrooms</a>
				</div>
				<h1 class="txt-align-center txt-white">Classes</h1>
				<div class="center-align-container">
					<input type="text" onKeyUp="onSearch()" class="primary-input" placeholder='Enter Class to Search'>
				</div>
				<div class="table-container">
					<?php
						$conn = mysqli_connect("localhost","root","","TimeTableProject");
						if($conn){
							$sql = "select * from classes where College_name = '".$_SESSION['admin']."'";
							$result = mysqli_query($conn,$sql);
							while($row = mysqli_fetch_assoc($result)){
								echo '<script>' . 'classesData.push(' . json_encode($row, JSON_HEX_TAG) . 
							');'. '</script>';
								echo "<a href='./selectDay.php?class=".$row['id']."' class='primary-btn m-10'>".$row['Year'].' '.$row['Division']."</a>";
							}
						}
					?>

				</div>

		
			</div>
		</div>
	</body>
</html>
