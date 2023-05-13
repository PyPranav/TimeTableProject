<?php
session_start();
if(isset($_POST['collage_name'])){
    $email = $_POST['email'];
    $collage_name = $_POST['collage_name'];
    $password = $_POST['password'];
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
    if($conn){
		try {
			$sql = "insert into colleges values('$collage_name','$password','$email')";
			$result = mysqli_query($conn,$sql);
			$_SESSION['admin'] = $collage_name;
			header("Location: ./home.php");
		} catch (\Throwable $th) {
			echo "<script>alert('Something went wrong');</script>";
		}
        
    }
    else{
        echo "<script>alert('Something went wrong');</script>";
    }
}
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>SignUp Page</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
	<div class="nav">
		<a href="./"> <button class="nav-btn">Home</button></a>
	</div>
	<div class="form-cont">
		<div class="form-box">
			<form method=post action=signup.php onsubmit="return check();">
				<h1 id="header"> Register </h1>
				<div class="text-inp">
					<input type=email name='email' id="email" placeholder="Email">
					<input type=text name='collage_name' maxlength=20 placeholder="College Name" id="name">
					<input type=password name='password' id="pass" placeholder="Password">

					<input type=password id="confPass" placeholder="Confirm password">
				</div>
				<p>already have a account? <a href="./login.php">Login</a></p>
				<div class="btn">
					<input type=submit value=Register>
				</div>

		</div>
	</div>
	</form>
	<script src="signupValidation.js"></script>
</body>

</html>