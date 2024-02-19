<?php
// Initialize the session
session_start();

if (isset($_SESSION['Student_Id']) && isset($_SESSION['U_Name'])) {
    include "../conn.php";
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../styles/styles.css?v=<?php echo time(); ?>">
    <title>Attendance</title>
    <script src="https://kit.fontawesome.com/fe3a67443d.js" crossorigin="anonymous"></script>
    </head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<body>
<?php include('child_header.php'); ?> 

    <div class="sec_attendance">
        <div class="attendance_card">
            
                <div class="title">
                    <h3>Attendance Analysis</h3>
                </div>
                <div>
                    <canvas class="chart" id="myChart" ></canvas>
                </div> 
                <div class="css-rainbow-text"><i> Attend Today.... <br> Achieve Tomorrow....</i><br>
                <img src="../../img/edu1.png" ></div>  
        </div>

        <div class="attendance-report">
                    <div class="heading">
                        <h3>Student Attendence</h3>
                    </div>
                    <div class="std-row">
                    <form action="" method="post" class="mb-3">
                        <div class="std-form-container">      
                        Start Date &nbsp; &nbsp;&nbsp; &nbsp; <input type='date' class='dateFilter' name='fromdate'>

                        End Date &nbsp; &nbsp; &nbsp;<input type='date' class='dateFilter' name='enddate' >


                        <button type="submit" name="attendsubmit" class="btn btn-primary">Submit</button>
                        </div>
                            
                    </form>   
                    <?php
                   
                   if(isset($_POST['attendsubmit'])){
                   if( !empty($_POST['fromdate'])  && !empty($_POST['enddate']))  {
                          
                       
                       $id=$_SESSION['Student_Id'];
                       $fromDate = $_POST['fromdate'];
                       $endDate = $_POST['enddate'];
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
         </div>
    </div>
    <script>

            var xValues = [" Attendance(80%)", "Absent(40%)"];
            var yValues = [80, 40];
            var barColors = [
            "#00aba9",
            "#b91d47",
            ];
              new Chart("myChart", {
              type: "doughnut",
              data: {
              labels: xValues,
              datasets: [{
              backgroundColor: barColors,
              data: yValues
            }]
        },
      
        });
 
            </script>
            
            
    </body>
</html>
<?php 
}else{
    header("Location: http://localhost/First_Project/pages/login.php");
     exit();
}
 ?>