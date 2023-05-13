<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.css" integrity="sha512-Uw2oepxJJm1LascwjuUQ904kRXdxvf6dLGH5GQYTg/eZBS3U4aR1+BhpIQ1nzHXoMDa5Xi5j8rEHucyi8+9kVg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<link rel="stylesheet" href="../styles.css" />
    <script>
        let teacherData = []
		let subjectData = []
        let deleteId = []
        let curNewId = -1;
        addRow = ()=>{
            teacherData.push({
                id: curNewId,
                subject_id: subjectData[0].id
            })
            reRenderTable()
            // setTimeout(()=>{editItem(curNewId)
            curNewId--
        }
        saveData = ()=>{
            var xhr = new XMLHttpRequest();

            //👇 set the PHP page you want to send data to
            xhr.open("POST", "./saveTeacher.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            //👇 what to do when you receive a response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    alert(xhr.responseText);
                    // alert("Data Saved!!")
                    window.location.reload()
                }
            };

            //👇 send the data
            xhr.send(JSON.stringify({teacherData,deleteId}));

        }
    </script>
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
        if($conn){
            $sql = "select * from Teachers inner join Subject on Teachers.subject_id = Subject.id where Teachers.college_name = '".$_SESSION['admin']."'";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                echo '<script>' . 'teacherData.push(' . json_encode($row, JSON_HEX_TAG) . 
            ');'. '</script>';
            }

			$sql = "select * from Subject where College_name = '".$_SESSION['admin']."'";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                if ($row['sname']=='BREAK') continue;
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
                    <th>Teacher Name</th>
                    <th>Subject</th>
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
                <input class="primary-btn" type='button' value='Add teacher'onclick="addRow()">
                <input class="primary-btn" type='button' value='Save'onclick="saveData()">
                
            </div>
    </section>

            </div>
        </div>
        <script>
            const temp = (id)=>{
                if(id)deleteId.push(id)
                    teacherData = teacherData.filter(x=>x.tid!=id)
                    
                    console.log(id)
                    reRenderTable()
            }
            // const editItem = (id)=>{
            //     // let teacher,name,n
            //     const teacher = teacherData.find(x=>x.id==id)
            //     const name = prompt("Enter Teacher Name",teacher.name)??""
            //     const normalDuration = prompt("Enter Normal Duration",teacher.normalDuration)??""
            //     const isLab = prompt("Enter isLab",teacher.isLab)??"0"
            //     let labDuration;
            //     if (isLab == "1")
            //          labDuration = prompt("Enter Lab Duration",teacher.labDuration)
            //     else
            //          labDuration ="0";
            //     teacher.name = name
            //     teacher.normalDuration = normalDuration
            //     teacher.isLab = isLab
            //     teacher.labDuration = labDuration
            //     reRenderTable()
            // }
			console.log(teacherData)
			// INSERT INTO `Teachers` (`name`, `subject_id`, `college_name`) VALUES ('Smitha Joshi', '7', 'pce');
            const nameChange = (i)=>{
				teacherData[i].tname = document.querySelector(`#name_${i}`).value
			}
			const subjectChange = (i)=>{
				teacherData[i].subject_id = document.querySelector(`#subject_${i}`).value
			}
			const reRenderTable = () => {document.querySelector("tbody").innerHTML = teacherData.map((teacher,i) => {
                
                return `<tr class='${teacher.id>=0?'oldEntry':'newEntry'}'>
                    <td><input type='text' onChange='nameChange(${i})' id='name_${i}' class='primary-input' value='${teacher.tname??""}'></td>
                    <td>
				
					<select id='subject_${i}' onChange='subjectChange(${i})' class="drop-down" name="college_name">
							${subjectData.map((subject) => {
								return `<option value="${subject.id}" ${teacher.subject_id==subject.id?'selected':''}>${subject.sname}</option>`;
							})}
					</select>
					
					</td>
                    <td>
                        <button class="primary-btn" onClick="temp(${teacher.tid})">Delete</button>
                    </td>
                </tr>`
            }).join('')
			$(".drop-down").selectize({
				sortFeild: "text",
			})
			$(".selectize-input").css("background", "#75bdd0").css("border", "None").css('box-shadow', 'none');

		
		}
            reRenderTable()
			
        </script>
</body>
</html>