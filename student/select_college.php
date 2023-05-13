
<?php
session_start();
// echo $_GET['college_name'];
if(isset($_GET['college_name'])) {
    $_SESSION['college_name'] = $_GET['college_name'];
    print_r($_SESSION);
    session_write_close();
    
    header("Location: ./student_home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Select College</title>
		<link rel="stylesheet" href="styles.css" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.css" integrity="sha512-Uw2oepxJJm1LascwjuUQ904kRXdxvf6dLGH5GQYTg/eZBS3U4aR1+BhpIQ1nzHXoMDa5Xi5j8rEHucyi8+9kVg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	</head>
	<body>
		<div class="container">
			<ul>
				<li class="nav-item">Home</li>
				<li class="nav-item">Admin</li>
			</ul>
		</div>
		<form action="./select_college.php" method="GET">
			<div class="main-select-form-container">
				<div class="select-form-container">
					<label for="college_name">Select College</label>
					<select class="drop-down" name="college_name" id="college_name">
						<option value="" disabled selected>Select College</option>
                    <?php
                        $servername = "localhost";
                        $database = "TimeTableProject";
                        $username = "root";
                        $password = "";
                        $conn = mysqli_connect($servername, $username, $password, $database);
                        // Check connection
                        if ($conn==false) {
                            die("Connection failed: " . mysqli_connect_error());
                        }
                        $sql = "SELECT * FROM `Colleges`";
                        if($result = mysqli_query($conn, $sql)){
                    
                            if(mysqli_num_rows($result) > 0){
                            
                                while($row = mysqli_fetch_array($result)){
                            
                                    echo "<option value='".$row['College_Name']."'>" . $row['College_Name'] . "</option>";
                                }
                            }
                        }
                        ?>
					</select>
					<input type="submit" class="submit-btn" value="Submit" />
				</div>
			</div>
		</form>
		<script>
			  $(document).ready(function () {
			$("#college_name").selectize({
				sortFeild: "text",
			})
			$(".selectize-input").css("background", "#75bdd0").css("border", "None").css('box-shadow', 'none');
		});

		</script>
	</body>
</html>

