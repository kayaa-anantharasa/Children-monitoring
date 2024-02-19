<?php
// Initialize the session
session_start();
if (isset($_SESSION['Parent_Id']) && isset($_SESSION['U_Name'])) {
  include "../conn.php";
  echo $_SESSION['Parent_Id'];
if (isset($_POST['op']) && isset($_POST['np']) && isset($_POST['c_np'])) {
   
 
    $op =$_POST['op'];
	$np = $_POST['np'];
	$c_np = $_POST['c_np'];
    //$op = md5($op);
   // $np = md5($np);


  $id =$_SESSION['Parent_Id'];
  echo $id;
  echo $op;
    $sql = "SELECT *
            FROM parent WHERE 
            Parent_Id='$id' AND Password='$op'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) === 1){
        
        $sql_2 = "UPDATE parent
                  SET Password='$np'
                  WHERE Parent_Id='$id'";
        mysqli_query($conn, $sql_2);
        
        $sql_3 = "UPDATE user
                  SET Password='$np'
                  WHERE Parent_Id='$id'";
        mysqli_query($conn, $sql_3);  
        header("Location: parent-setting.php?success=Incorrect password");
        exit();
    }
else {
    header("Location: parent-setting.php?error=Incorrect password");
    exit();
}
    
}


}else{
  header("Location: http://localhost/First_Project/pages/login.php");
exit();
}


?>