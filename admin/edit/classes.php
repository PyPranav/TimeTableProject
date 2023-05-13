<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Classes</title>
	<link rel="stylesheet" href="../styles.css" />
    <script>
        let classesData = []
        let deleteId = []
        let curNewId = -1;
        addRow = ()=>{
            classesData.push({
                id: curNewId,
                Year: "",
                Division: "",
            })
            reRenderTable()
            setTimeout(()=>{editItem(curNewId)
            curNewId--},100)
        }
        saveData = ()=>{
            console.log(classesData)
            var xhr = new XMLHttpRequest();

            //👇 set the PHP page you want to send data to
            xhr.open("POST", "./saveClasses.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            //👇 what to do when you receive a response
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE) {
                    // alert(xhr.responseText);
                    alert("Data Saved!!")
                }
            };

            //👇 send the data
            xhr.send(JSON.stringify({classesData,deleteId}));

        }
    </script>
    <?php
    session_start();
    if (!isset($_SESSION['admin'])) {
        header("Location: ../login.php");
    }
    $conn = mysqli_connect("localhost","root","","TimeTableProject");
        if($conn){
            $sql = "select * from Classes where College_name = '".$_SESSION['admin']."'";
            $result = mysqli_query($conn,$sql);
            while($row = mysqli_fetch_assoc($result)){
                echo '<script>' . 'classesData.push(' . json_encode($row, JSON_HEX_TAG) . 
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
                    <th>Year</th>
                    <th>Division</th>
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
                <input class="primary-btn" type='button' value='Add Class'onclick="addRow()">
                <input class="primary-btn" type='button' value='Save'onclick="saveData()">
                
            </div>
    </section>

            </div>
        </div>
        <script>
            const temp = (id)=>{
                if(id)deleteId.push(id)
                    classesData = classesData.filter(x=>x.id!=id)
                    
                    console.log(id)
                    reRenderTable()
            }
            const editItem = (id)=>{
                // let classes,name,n
                const classes = classesData.find(x=>x.id==id)
                const Year = prompt("Enter Year",classes.Year)??""
                const Division = prompt("Enter Division",classes.Division)??""
                
                classes.Year = Year
                classes.Division = Division
                reRenderTable()
            }
            const reRenderTable = () => document.querySelector("tbody").innerHTML = classesData.map((classes) => {
                
                return `<tr>
                    <td>${classes.Year}</td>
                    <td>${classes.Division}</td>
                    <td>
                        <button class="primary-btn" onClick='editItem(${classes.id})'>Edit</button>
                        <button class="primary-btn" onClick="temp(${classes.id})">Delete</button>
                    </td>
                </tr>`
            }).join('')
            reRenderTable()
        </script>
</body>
</html>