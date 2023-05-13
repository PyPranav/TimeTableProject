<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Subjects</title>
	<link rel="stylesheet" href="../styles.css" />
    <script>
        let subjectData = []
        let deleteId = []
        let editList = []
        let editId=[]
        let curNewId = -1;
        addRow = ()=>{
            subjectData.push({
                id: curNewId,
                sname: "",
                normalDuration: "",
                isLab: "0",
                labDuration: ""
            })
            reRenderTable()
            setTimeout(()=>{editItem(curNewId)
            curNewId--},100)
        }
        saveData = ()=>{
            console.log(subjectData)
            var xhr = new XMLHttpRequest();

            //👇 set the PHP page you want to send data to
            xhr.open("POST", "./saveSubjects.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            //👇 what to do when you receive a response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    // alert(xhr.responseText);
                    alert("Data Saved!!")
                }
            };

            //👇 send the data
            xhr.send(JSON.stringify({subjectData,deleteId,editList,editId}));

        }
    </script>
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
        if($conn){
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
                    <th>Subject Name</th>
                    <th>Normal Duration</th>
                    <th>isLab</th>
                    
                    <th>Lab Duration</th>
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
                <input class="primary-btn" type='button' value='Add Subject'onclick="addRow()">
                <input class="primary-btn" type='button' value='Save'onclick="saveData()">
                
            </div>
    </section>

            </div>
        </div>
        <script>
            const temp = (id)=>{
                if(id>=0)deleteId.push(id)
                
                    subjectData = subjectData.filter(x=>x.id!=id)
                    
                    console.log(id)
                    reRenderTable()
            }
            const editItem = (id)=>{
                // let subject,name,n
                
                const subject = subjectData.find(x=>x.id==id)
                const sname = prompt("Enter Subject Name",subject.sname)??""
                const normalDuration = prompt("Enter Normal Duration",subject.normalDuration)??""
                const isLab = prompt("Enter isLab",subject.isLab)??"0"
                let labDuration;
                if (isLab == "1")
                     labDuration = prompt("Enter Lab Duration",subject.labDuration)
                else
                     labDuration ="0";

                if(id>=0){
                    editList.push(subject)
                    editId.push(id)
                }
                subject.sname = sname
                subject.normalDuration = normalDuration
                subject.isLab = isLab
                subject.labDuration = labDuration
                reRenderTable()
            }
            const reRenderTable = () => document.querySelector("tbody").innerHTML = subjectData.map((subject) => {
                
                return `<tr>
                    <td>${subject.sname}</td>
                    <td>${subject.normalDuration}</td>
                    <td><input type="checkbox" class="largerCheckbox" name="t" value="1" ${subject.isLab==="1" ? "checked" : ""} disabled></input></td>
                    <td>${subject.labDuration??""}</td>
                    <td>
                        <button class="primary-btn" onClick='editItem(${subject.id})'>Edit</button>
                        <button class="primary-btn" onClick="temp(${subject.id})">Delete</button>
                    </td>
                </tr>`
            }).join('')
            reRenderTable()
        </script>
</body>
</html>