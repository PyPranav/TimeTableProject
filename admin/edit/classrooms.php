<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Classrooms</title>
		<link rel="stylesheet" href="../styles.css" />
    <script>
        let classroomData = []
		let subjectData = []
        let deleteId = []
        let curNewId = -1;
        addRow = ()=>{
            classroomData.push({
                Room_id: curNewId,
                isLab:'0'
            })
            reRenderTable()
            // setTimeout(()=>{editItem(curNewId)
            curNewId--
        }
        saveData = ()=>{
            var xhr = new XMLHttpRequest();

            //👇 set the PHP page you want to send data to
            xhr.open("POST", "./saveClassroom.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            //👇 what to do when you receive a response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    // alert(xhr.responseText);
                    alert("Data Saved!!")
                    window.location.reload()
                }
            };

            //👇 send the data
            xhr.send(JSON.stringify({classroomData,deleteId}));

        }
    </script>
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
        if($conn){
            $sql = "select * from Classrooms where college_name = '".$_SESSION['admin']."' order by Room_no";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                echo '<script>' . 'classroomData.push(' . json_encode($row, JSON_HEX_TAG) . 
            ');'. '</script>';
            }

			$sql = "select * from Subject where College_name = '".$_SESSION['admin']."'";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                echo '<script>' . 'subjectData.push(' . json_encode($row, JSON_HEX_TAG) . 
            ');'. '</script>';
            }
        }
					
    ?>
</head>
<body>
	<a  class='primary-btn logout' href="../logout.php">Logout</a>
<div class="container">
			<ul>
				<li class="nav-item"><a href="../../student/student_home.php" class='text-dec-none'> Home </a></li>
				<li class="nav-item"><a href="../home.php" class='text-dec-none'> Admin </a></li>
			</ul>
		</div>
        <div class='grid-center'>
			<div class="master-box">


            <section>
            <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                <tr>
                    <th>Classroom No.</th>
                    <th>isLab</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
            </div>
            <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    
                    
                        
                    
                </tbody>
            </table>
            </div>
            <div style="text-align: center; margin-top:3%">
                <input class="primary-btn" type='button' value='Add classroom'onclick="addRow()">
                <input class="primary-btn" type='button' value='Save'onclick="saveData()">
                
            </div>
    </section>

            </div>
        </div>
        <script>
            const temp = (id)=>{
                if(id)deleteId.push(id)
                    classroomData = classroomData.filter(x=>x.Room_id!=id)
                    
                    console.log(id)
                    reRenderTable()
            }
			console.log(classroomData)
			// INSERT INTO `classrooms` (`name`, `subject_id`, `college_name`) VALUES ('Smitha Joshi', '7', 'pce');
            const nameChange = (i)=>{
				classroomData[i].Room_no = document.querySelector(`#name_${i}`).value
			}
			const labStatusChange = (i)=>{
                console.log(document.querySelector(`#labStatus_${i}`).checked)
				classroomData[i].isLab = document.querySelector(`#labStatus_${i}`).checked?"1":"0"
			}
			const reRenderTable = () => {document.querySelector("tbody").innerHTML = classroomData.map((classroom,i) => {
                
                return `<tr class='${classroom.Room_id>=0?'oldEntry':'newEntry'}'>
                    <td><input type='text' onChange='nameChange(${i})' id='name_${i}' class='primary-input' value='${classroom.Room_no??""}'></td>
                    <td>
				
					<input type="checkbox" id='labStatus_${i}' onChange='labStatusChange(${i})' class="largerCheckbox" name="t" value="1" ${classroom.isLab==="1" ? "checked" : ""}></input>
					
					</td>
                    <td>
                        <button class="primary-btn" onClick="temp(${classroom.Room_id})">Delete</button>
                    </td>
                </tr>`
            }).join('')
		
		
		}
            reRenderTable()
			
        </script>
</body>
</html>