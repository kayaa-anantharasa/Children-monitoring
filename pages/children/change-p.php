<?php 
session_start();

if (isset($_SESSION['Student_Id']) && isset($_SESSION['U_Name'])) {
	include "../conn.php";
echo $_SESSION['Student_Id'];
if (isset($_POST['op']) && isset($_POST['np'])
    && isset($_POST['c_np'])) {

	 if($np !== $c_np){
      header("Location: change-password.php?error=The confirmation password  does not match");
	  exit();
    }else {
    	// hashing the password
    	//$op = md5($op);
    	//$np = md5($np);
        $id = $_SESSION['Student_Id'];

        $sql = "SELECT password
                FROM user WHERE 
                Student_Id='$id' AND password='$op'";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) === 1){
        	
        	$sql_2 = "UPDATE user
        	          SET password='$np'
        	          WHERE Student_Id='$id'";
        	mysqli_query($conn, $sql_2);
        	header("Location: change-password.php?success=Your password has been changed successfully");
	        exit();

        }else {
        	header("Location: change-password.php?error=Incorrect password");
	        exit();
        }

    }

    
}else{
	header("Location: change-password.php");
	exit();
}

}else{
    header("Location: http://localhost/First_Project/pages/login.php");
     exit();
}
?>