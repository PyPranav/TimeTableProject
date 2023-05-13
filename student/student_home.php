<?php
session_start();
// print_r($_SESSION);

if (!isset($_SESSION['college_name'])) {
    header("Location: ./select_college.php");
    exit();
}
$college_name =  $_SESSION['college_name']
?>
<!DOCTYPE html>
<html lang='en'>

<head>
	<title>Student</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel='stylesheet' href='styles.css'>
	<style>
		.searchBar__cont {
			display: flex;
			justify-content: center;
			align-items: center;
		}

		#classSearch {
			border-radius: 10px;
			width: 50vw;
			height: 30px;
			font-size: 1rem;
		}

		#nav {
			height: 50px;
			display: flex;
			align-items: center;
			gap: 40px;
			flex-direction: row;
			background-color: #16697A;
		}

		#nav a {
			text-decoration: none;
			color: black;
		}

		#nav a:hover {
			text-decoration: underline;
		}

		#nav button {
			padding: 5px 0 5px 0;
			width: 70px;
		}

		@media only screen and (max-width: 500px) {
			#nav a {
				display: none;
			}

			.tab label {
				font-size: 8px;
			}
		}

		.complaints_cont {
			display: flex;
			justify-content: center;
			align-items: center;
			gap: 20px;
			flex-direction: column;
		}

		.fname_input {
			width: 30vw;
			padding: 8px 13px;
			border:none;
			background-color: #75bdd0;
			border-radius: 3px;
			margin: 20px 10px;
			opacity: 0.8;
		}

		#classroom_select,
		#complaint_select {

			background-color: #75bdd0;
			border:none;
			width: 30vw;
			border-radius: 3px;
			opacity: 0.8;
			padding: 8px 13px;
		}
	</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js" integrity="sha512-qZvrmS2ekKPF2mSznTQsxqPgnpkI4DNTlrdUmTzrDgektczlKNRRhy5X5AAOnx5S09ydFYWWNSfcEqDTTHgtNA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	
</head>

<body>
		<div class="container">
		<ul>
				<li class="nav-item"><a href="./student_home.php" class='text-dec-none'> Home </a></li>
				<li class="nav-item"><a href="../admin/home.php" class='text-dec-none'> Admin </a></li>
			</ul>
		</div>

	<div class='home-wel'><?php echo "Welcome, ".$college_name?></div>
	<div style="display:flex; align-items:center; justify-content:center">
		<div class="tabbed">
			<input type="radio" id="tab1" name="css-tabs" checked>
			<input type="radio" id="tab2" name="css-tabs">

			<ul class="tabs">
				<li class="tab"><label for="tab1">Time Tables</label></li>
				<li class="tab"><label for="tab2">Complain</label></li>
			</ul>

			<div class="tab-content">
			<div class=" searchBar__cont" style='margin:20px;'>
				<input id="classSearch" onKeyUp="sname_ret()" type="search" placeholder='Enter Class to search'>
			</div>
				<div class="time_table_tab" id='classes_tab'>
				</div>
			</div>

			<div class="tab-content">

			<form action="complainsPost.php" method="post">
				<div class="complaints_cont">
						<div>
							<label class='txt-white' for="classroom">Classroom:</label>
							<select name="room_id" id="classroom_select">
								<?php
								 
    								$conn = mysqli_connect("localhost","root","","TimeTableProject");
								 if($conn){
									$sql = "select * from Classrooms where college_name = '".$_SESSION['college_name']."' order by Room_no";
									$result = mysqli_query($conn,$sql);
									while($row = mysqli_fetch_assoc($result)){
										echo  '<option value="'.$row["Room_id"].'">'.$row['Room_no'].'</option>';
									}
								}
								?>
								<!-- <option value="s-202">S-202</option> -->
							</select>
						</div>
						<div>
							<label class='txt-white' for="complaint">Complaint:</label>
							<!-- <select name="complain" id="complaint_select">
								<option value="fans">Fans not working</option>
							</select> -->
							<input name="complain" class="fname_input" type=text maxlength=20 placeholder="Your Compaint" id="name" required>
						
						</div>
						<div>
						<label class='txt-white' for="sname">Student name:</label>
							<input name='sname' class="fname_input" type=text maxlength=20 placeholder="Full name" id="name" required>
						</div>
						<input type="submit" onClick="test()" class='primary-btn'value="Submit">
					
				</div></form>
			</div>
		</div>


	</div>

	
<script>
	window.jsPDF = window.jspdf.jsPDF;
const generateYCenteredTextCoordinate = (
  doc,
  boxX,
  boxY,
  boxWidth,
  boxHeight,
  txt
) => {
  let txtWidth = doc.getTextWidth(txt)
  let avgLenPerChar = txtWidth / txt.length
  // console.log(txt, doc.getTextDimensions(txt), txtWidth, boxWidth, doc)
  if (txtWidth > boxWidth) {
    let excessLen = txtWidth - boxWidth
    txt = txt.slice(0, Math.round((txtWidth - excessLen) / avgLenPerChar) - 4) + '...'

    txtWidth = doc.getTextWidth(txt)
  }
  let x, y
  y = boxHeight / 2 + doc.getTextDimensions(txt).h / 4 + boxY
  // console.log(, txtWidth)
  x = boxX
  return [txt, x, y]
}

const generateXYCenteredTextCoordinate = (
  doc,
  boxX,
  boxY,
  boxWidth,
  boxHeight,
  txt
) => {
  let coord = generateYCenteredTextCoordinate(doc, boxX, boxY, boxWidth, boxHeight, txt)
  coord[1] = boxX + (boxWidth / 2 - (doc.getTextWidth(coord[0]) + doc.getCharSpace() * (coord[0].length - 1)) / 2)
  return coord
}

const genereateRightAlignedTextCoordinate = (
  doc,
  boxX,
  boxY,
  boxWidth,
  boxHeight,
  txt
) => {
  let coord = generateYCenteredTextCoordinate(doc, boxX, boxY, boxWidth, boxHeight, txt)
  coord[1] = boxX + (boxWidth - (doc.getTextWidth(coord[0]) + doc.getCharSpace() * (coord[0].length - 1)))
  return coord
}

	const generatePDF = (id)=>{
		let slotsArr = []
		console.log(id)
		var xhr;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE 8 and older
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
		var data = "id=" + id ;
		xhr.open("POST", "getSlots.php", true); 
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
		xhr.send(data);
	xhr.onreadystatechange = display_data;

		function display_data() {
		if (xhr.readyState == 4) {
		if (xhr.status == 200) {
		// alert(xhr.responseText);	   
		slotsArr = xhr.responseText.split(' gap_here ').slice(0,-1);
		slotsArr = slotsArr.map((slot)=>JSON.parse(slot))
		generatePDF2(slotsArr)
		}
		else {
			alert('There was a problem with the request.');
		}
		}
		}
		
	}

	const generatePDF2 = (slots)=>{
		let doc = new jsPDF('landscape');

		// doc.rect(5, 5, 285, 200)
		for(i=1;i<6;i++){
			doc.rect(5+20, 5, 52*i, 200)
		}
		for(i=1;i<=10;i++){
			doc.rect(5, 5+200-185, 260+20, 18.5*i)
		}
		doc.setFontSize(12)

		let days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']
		{
			let timeSlots = ['8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-1:00', '1:00-2:00', '2:00-3:00', '3:00-4:00', '4:00-5:00', '5:00-6:00']
			days.forEach((day, i)=>{
				// doc.rect( 5+20+(52)*i, 5+200-185, 52, 18.5)
				doc.text(...generateXYCenteredTextCoordinate(doc,5+20+(52)*i, 5, 52, 200-185, day))
			})
			doc.setFontSize(10)
			timeSlots.forEach((time, i)=>{
				// doc.rect( 5, 5+200-185+(18.5)*i, 20, 18.5)
				doc.text(...generateXYCenteredTextCoordinate(doc,5, 5+200-185+(18.5)*i, 20, 18.5, time))
			})
		}
		doc.setFontSize(12)
		let dayStartTime = new Date("01/01/2007 "+"08:00:00").getHours()
		days.forEach((day,i)=>{
			slot = slots[i]

			console.log(day, slot)
			slot.forEach((slot, o)=>{
					let j = new Date("01/01/2007 "+slot.startTime).getHours()-dayStartTime
					let dur = - new Date("01/01/2007 "+slot.startTime).getHours() + new Date("01/01/2007 "+slot.endTime).getHours()
					for(k=0;k<dur;k++){
						
						doc.setFillColor(239, 239, 240);
						doc.rect( 5+20+(52)*i+1, 5+200-185+(18.5)*(j+k)+1, 52-2, 18.5-2,'F')
						

						doc.setFontSize(12)
						if(slot.sname!="BREAK"){
						doc.text(...generateXYCenteredTextCoordinate(doc,5+20+(52)*i, 5+200-185+(18.5)*(j+k), 52, 12, slot.sname))
						doc.setFontSize(10)
						doc.text(...generateXYCenteredTextCoordinate(doc,5+20+(52)*i, 5+200-185+(18.5)*(j+k)+4, 52, 12, slot.tname))
						// doc.setFontSize(8)
						doc.text(...generateXYCenteredTextCoordinate(doc,5+20+(52)*i, 5+200-185+(18.5)*(j+k)+8, 52, 12, slot.Room_no))
						}
						else{
							doc.text(...generateXYCenteredTextCoordinate(doc,5+20+(52)*i, 5+200-185+(18.5)*(j+k), 52, 18.5, "BREAK"))
						}
					}
			})
		})
		window.open(URL.createObjectURL(doc.output('blob')))
	}
	test = ()=>{
		if(document.getElementById("name").value!="")
		alert("Complaint Submitted");
	}
function sname_ret()
	{
	var q = document.getElementById("classSearch").value;
	document.getElementById("classes_tab").innerHTML = "";
	var xhr;
	if (window.XMLHttpRequest) { // Mozilla, Safari, ...
		xhr = new XMLHttpRequest();
	} else if (window.ActiveXObject) { // IE 8 and older
		xhr = new ActiveXObject("Microsoft.XMLHTTP");
	}
		var data = "year=" + q.split(" ")[0] + "&division="+(q.split(" ")[1]??"");
		xhr.open("POST", "getClasses.php", true); 
		xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
		xhr.send(data);
	xhr.onreadystatechange = display_data;

		function display_data() {
		if (xhr.readyState == 4) {
		if (xhr.status == 200) {
		// alert(xhr.responseText);	   
			document.getElementById("classes_tab").innerHTML += xhr.responseText;
		}
		else {
			alert('There was a problem with the request.');
		}
		}
		}
	}
	sname_ret();
</script>


</body>

</html>