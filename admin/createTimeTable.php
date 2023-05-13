<?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
        
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Time Table</title>
	<link rel="stylesheet" href="./styles.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.css" integrity="sha512-Uw2oepxJJm1LascwjuUQ904kRXdxvf6dLGH5GQYTg/eZBS3U4aR1+BhpIQ1nzHXoMDa5Xi5j8rEHucyi8+9kVg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js" integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<style>
    label{
        display:grid;
        place-items:center;
    }
</style>
<script>
    subjectsList = [{id:"",name:"None"}];
    teachersList = [];
</script>
<body>
	<a  class='primary-btn logout' href="./logout.php">Logout</a>
    <div class="container">
            <ul>
				<li class="nav-item"><a href="../student/student_home.php" class='text-dec-none'> Home </a></li>
				<li class="nav-item"><a href="./home.php" class='text-dec-none'> Admin </a></li>
			</ul>
	</div>
    <div class='grid-center'>
		<div class="master-box">
            <section>
            <div class='center-align-container m-20'>
                <label for="start-time">Start Time</label>
                <input class="primary-btn" id='start-time' name='start-time' type='time'>
                <label for="end-time">End Time</label>
                <input class="primary-btn" id='end-time' name='end-time' type='time'>
                </div>

                <div class='center-align-container m-20'>  

                <label for="subject">Subject</label>
                <select  style='min-width:200px' class='custom-select' id='subject' name="subject">
                    <?php
                        // $subjectData = $subject->getSubject();
                        // foreach($subjectData as $subject){
                        //     echo "<option value='".$subject['id']."'>".$subject['sname']."</option>";
                        // }
                        if($conn){
                            $sql = "select * from Subject where college_name = '".$_SESSION['admin']."'";
                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                // echo  '<option value="'.$row["id"].'">'.$row['sname'].'</option>';
                                echo '<script>subjectsList.push({id:'.$row["id"].',name:"'.$row['sname'].'"});
                                    subjectsList[0].id = '.$row["id"].';
                                </script>';
                            }
                        }
                        ?>
				</select>
                <label for="teacher">Teacher</label>
                <select  style='min-width:200px' id='teacher' class='custom-select' name="teacher">
                    <?php
                        // $subjectData = $subject->getSubject();
                        // foreach($subjectData as $subject){
                        //     echo "<option value='".$subject['id']."'>".$subject['sname']."</option>";
                        // }
                        if($conn){
                            $sql = "select * from Teachers where college_name = '".$_SESSION['admin']."'";
                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                // echo  '<option value="'.$row["tid"].'">'.$row['tname'].'</option>';
                                echo '<script>teachersList.push({id:'.$row["tid"].',name:"'.$row['tname'].'", subject:"'.$row['subject_id'].'"});
                                            
                                </script>';
                                
                            }
                        }
                        ?>
				</select>
                <label for="classroom">Classroom</label>
                <select  style='min-width:200px'  id='classroom' class="drop-down" name="classroom">
                    <?php
                        // $subjectData = $subject->getSubject();
                        // foreach($subjectData as $subject){
                        //     echo "<option value='".$subject['id']."'>".$subject['sname']."</option>";
                        // }
                        if($conn){
                            $sql = "select * from Classrooms where college_name = '".$_SESSION['admin']."'";
                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                echo  '<option value="'.$row["Room_id"].'">'.$row['Room_no'].'</option>';
                            }
                        }
                        ?>
				</select>
                </div>
                <div class='right-align-container m-20'>  

                <input type="button" value='Add' onClick='addSlot()' class="primary-btn">

                </div>
                <div class="tbl-header">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th>Time Slot</th>
                                <th>Subject</th>
                                <th>Teacher</th>
                                <th>Classroom</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="tbl-content">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                            <?php
                            if($conn){
                                $sql = "select * from Slots inner join Subject on Slots.subject_id=Subject.id inner join Teachers on Slots.teacher_id=Teachers.tid inner join Classrooms on Slots.classroom_id = Classrooms.Room_id where Slots.college_name = '".$_SESSION['admin']."' and day = '".$_GET['day']."' and class_id = '".$_GET['class']."' order by startTime";
                                $result = mysqli_query($conn,$sql);
                                while($row = mysqli_fetch_assoc($result)){
                                    // echo "<script>slotData.push()</script>"
                                    echo  '<tr>
                                    <td>'.$row['startTime'].' - '.$row['endTime'].'</td>
                                    <td>'.$row['sname'].'</td>
                                    <td>'.($row['sname']!="BREAK"?$row['tname']:"NONE").'</td>
                                    <td>'.$row['Room_no'].'</td>
                                    <td><a class="primary-btn" href="./deleteSlot.php?slot_id='.$row['slot_id'].'">Delete</a></td>';
                                }
                            }
                            ?>
                            
                                
                            
                        </tbody>
                    </table>
                </div>
                
                </section>
        </div>
    </div>
    <script>
        subjectsList.forEach(subject=>{
            document.getElementById("subject").innerHTML += '<option value="'+subject.id+'">'+subject.name+'</option>';
        })  
        
        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for(var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }
        const addSlot = ()=>{
            const startTime = $("#start-time").val()
            const endTime = $("#end-time").val()

            if(startTime=='' || endTime=='') return alert("Please enter time slot")
            if(startTime>=endTime) return alert("Start time should be less than end time");
            if(startTime<"08:00" || endTime>"18:00") return alert("Time slot should be between 8:00 AM to 6:00 PM");
            const subject = $("#subject").val()
            if(subjectsList.find(sub=>sub.id==subject).name=="None") return alert("Select A valid Subject")
            
            const classroom = $("#classroom").val()
            let teacher = $("#teacher").val()
            if(subjectsList.find(sub=>sub.id==subject).name=="BREAK") teacher=teachersList[0].id
            console.log(startTime,endTime, subject, classroom,teacher)

            var xhr = new XMLHttpRequest();

            //👇 set the PHP page you want to send data to
            xhr.open("POST", "./runSQLcmd.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            //👇 what to do when you receive a response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    let resp = xhr.responseText;
                    if(xhr.responseText!='Data Saved!')
                        alert(xhr.responseText)
                    // alert("Data Saved!!")
                    window.location.reload();
                    
                }
            };

            //👇 send the data
            xhr.send(JSON.stringify({q:`INSERT INTO Slots(classroom_id, startTime, endTime, subject_id, teacher_id, class_id, day, College_Name) values(${classroom}, '${startTime}', '${endTime}', ${subject}, ${teacher}, ${getUrlVars()['class']}, '${getUrlVars()['day']}'`, appendUser: true, day:getUrlVars()['day'], 'classId':getUrlVars()['class'] ,'start-time':startTime, 'end-time':endTime, 'subject':subject, 'classroom':classroom, 'teacher':teacher}));
            
        }
        $(".drop-down").selectize({
				sortFeild: "text",
			})
			$(".selectize-input").css("background", "#75bdd0").css("border", "None").css('box-shadow', 'none').css('min-width','200px');
            
            
            document.getElementById("subject").addEventListener("change", function(){
            const subjectId = this.value;
            console.log(subjectId)
            if(subjectsList.find(subject=>subject.id==subjectId).name=="None"){
                
                return;
            }
            teacherList = document.getElementById("teacher");
                console.log(teacherList)
            teacherList.innerHTML = "";
            teachersList.forEach(teacher=>{
                if(teacher.subject==subjectId){
                    console.log(subjectId)
                    teacherList.innerHTML += '<option value="'+teacher.id+'">'+teacher.name+'</option>';
                }
            })
        })

    </script>
</body>
</html>