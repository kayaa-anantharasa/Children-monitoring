<?php
// Initialize the session
session_start();

if (isset($_SESSION['Parent_Id']) && isset($_SESSION['U_Name'])) {
    include "../conn.php";
    $query = "SELECT count(*) as present_absent_count, Status,
    case
        when Status = 1 then 'Present'
        when Status = 0 then 'Absent'
      end as attendance FROM attendance WHERE Student_Id='8' GROUP BY attendance ;";
$result = mysqli_query($conn, $query);
$i=0;
while ($row = mysqli_fetch_array($result)) {
   $label[$i] = $row["Status"];
   $count[$i] = $row["present_absent_count"];
   $i++;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../styles/styles.css?v=<?php echo time(); ?>">
    <title>Document</title>
   

    <style>
    </style>
    <script type="text/javascript"src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">  
        // API initialization to create Google chart 
        google.charts.load('current', {'packages':['corechart']});  
        google.charts.setOnLoadCallback(drawPieChart);  

function drawPieChart()  
{  
    var pie = google.visualization.arrayToDataTable([  
              ['attendancede', 'Numbder'],
              ['<?php echo $label[0]; ?>', <?php echo $count[0]; ?>],
              ['<?php echo $label[1]; ?>', <?php echo $count[1]; ?>],
                    
         ]);  
    var header = {  
          title: '',
          slices: {0: {color: '#666666'}, 1:{color: '#34a0a4'}}
         };  
    var piechart = new google.visualization.PieChart(document.getElementById('piechart'));  
    piechart.draw(pie, header);  
} 
</script>
</head>
<body>
<?php include('header.php'); ?>
<div class="flex_attendance">
    <div class="select_attendance">
    <form action="" method="post" class="mb-3">
                <div class="class-attend-container" >
                    <br>
                        <label for="year">&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;Select Name &nbsp; &nbsp; </label> 
                        <select name="student-name" class="class-exam-select">
                            <option value="" disabled selected>--select--</option>
                                <?php 
                                    $bname = $_SESSION['Parent_Id'];
                                     $stmt = $conn->prepare("SELECT DISTINCT User_Name FROM student WHERE Parent_Id= ?");
                                     $stmt->bind_param("s", $bname);
                                     $stmt->execute();
                                     $result = $stmt->get_result();
                                    while($data = mysqli_fetch_array($result))
                                        {
                                            echo "<option value='". $data['User_Name'] ."'>" .$data['User_Name'] ."</option>";  
                                            // displaying data in option menu
                                        }
                                ?>
                        </select>
                        Start Date &nbsp; &nbsp;&nbsp; &nbsp; <input type='date' class='dateFilter' name='fromDate'>

                        End Date &nbsp; &nbsp; &nbsp;<input type='date' class='dateFilter' name='endDate' >

                       
                     <button type="submit" name="attend-submit" class="btn btn-primary">Submit</button>
                </div>
            </from>
            <br><br>
    </div>
    <div class="attendance">
        <div class="attendance_data">
            <h3 style="color: #1a659e;"><b>Attendance Analysis</b></h3>
            <?php
                   
                   if(isset($_POST['attend-submit'])){
                   if(!empty($_POST['student-name']) && !empty($_POST['fromDate'])  && !empty($_POST['endDate']))  {
                          
                       //select student id
                       $cname = $_POST['student-name'];
                       $user_check_child = "SELECT * FROM student WHERE User_Name='$cname' ";
                       //echo $U_Name, $P_Word;
                       $result_child = mysqli_query($conn, $user_check_child);
                       $row_c = mysqli_fetch_array($result_child, MYSQLI_ASSOC);
                       // Attempt select query execution
                       $id=$row_c['Student_Id'];
                       $fromDate = $_POST['fromDate'];
                       $endDate = $_POST['endDate'];
                       $result = mysqli_query($conn,"SELECT * FROM attendance WHERE Student_Id='$id' AND Date  between '$fromDate'  AND '$endDate' ");
                       if($result){
                       
                       echo  "<table class='table table-info table-success table-hover'>
                        <tr>
                       <th scope='col'>Date</th>
                       <th scope='col'>Status</th>
                       </tr>";
                    
                           while($row= mysqli_fetch_assoc($result)){

                               echo "<tr>";
                               echo "<td>" . $row['Date'] . "</td>";
                               echo "<td>" . $row['Status'] . "</td>";
                               echo "</tr>";

                           }
                           echo "</table>";
        }
                           
        else{
                           echo "No records matching your query were found.";
                       }
                       } else{
                           echo 'Please select the student name , start date and end date .';
                       }
                   }
                   
   ?>
        </div>
        <div class="img1">
        <img src="../img/attendance.jpg" height="300px" width="400px">
        </div>
        </div>
    </div>
    <div class="chart">
        <h3><b>Percentage of student attendance</b></h3>
    <div id="piechart">

    </div> 
    </div>  
</div>  

</body>

</html>
<?php 
}else{
    header("Location: http://localhost/First_Project/pages/login.php");
}
 ?>