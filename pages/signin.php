<?php
// Initialize the session
session_start();
//sign in user
include "./conn.php";
if (isset($_POST['U_Name']) && isset($_POST['P_Word'])){
    $U_Name =  $_POST['U_Name'];
    $P_Word = $_POST['P_Word'];
    //$P_Word  = md5($P_Word );

    $user_check = "SELECT * FROM user WHERE User_Name='$U_Name' ";
    $result = mysqli_query($conn,  $user_check);
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['User_Name'] === $U_Name && $row['Password'] === $P_Word ) {
            $_SESSION["U_Name"] = $row['User_Name'];
            $_SESSION["P_Word"] = $row['Password'];
            if ($row['Type'] === '1') {
                $user_check_parent = "SELECT * FROM parent WHERE User_Name='$U_Name' ";
            
            $result_Parent = mysqli_query($conn, $user_check_parent);
            $row5 = mysqli_fetch_array($result_Parent, MYSQLI_ASSOC);
            $count_parent = mysqli_num_rows($result_Parent);
           	
                 $_SESSION['Parent_Id']=$row5['Parent_Id'];	
           
                echo ('<script>window.location.replace("http://localhost/First_Project/pages/parent/parent-dashboard.php");</script>');
                
                }
            
           else if ($row['Type'] ==='2') {
                $user_check_teacher = "SELECT * FROM teacher WHERE User_Name='$U_Name' ";
            
            $result_IN_teacher = mysqli_query($conn, $user_check_teacher);
            $row2 = mysqli_fetch_array($result_IN_teacher, MYSQLI_ASSOC);
            $count_teacher = mysqli_num_rows($result_IN_teacher);
            $_SESSION['Teacher_Id']=$row2['Teacher_Id'];
           
          
                echo ('<script>window.location.replace("http://localhost/pages/teacher/teacher-dashboard.php");</script>');
               
            }
            else if ($row['Type'] ==='3') {
                $user_check_student = "SELECT * FROM student WHERE User_Name='$U_Name' ";
                   
            $result_student = mysqli_query($conn, $user_check_student);
            $row6 = mysqli_fetch_array($result_student, MYSQLI_ASSOC);
            $count_student = mysqli_num_rows($result_student);
            $_SESSION['Student_Id']=$row6['Student_Id'];
              
                echo ('<script>window.location.replace("http://localhost/First_Project/pages/children/children-dashboard.php");</script>');
               
            }
            exit();
        }else{
            header("Location: login.php?error=Incorect User name or password");
            exit();
        }
    }else{
        header("Location: login.php?error=Incorect User name or password");
        exit();
    }
}

else{
    header("Location: http://localhost/First_Project/pages/login.php");
exit();
}
?>