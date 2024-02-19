<?php
// Initialize the session
session_start();

if (isset($_SESSION['Parent_Id']) && isset($_SESSION['U_Name'])) {
    include "../conn.php";
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
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</head>
<body>
<?php include('header.php'); ?>
    <div class="con">
            <div class="user_Information">
                <form action="" method="POST">
                    <?php 
                    $sql="SELECT * FROM parent WHERE Parent_Id = '".$_SESSION['Parent_Id']."'";
                    $result=mysqli_query($conn,$sql);
                    $row=mysqli_fetch_assoc($result);

                    $username=$row['User_Name'];
                    $email=$row['Email'];
                    $fname=$row['First_Name'];
                    $lname=$row['Last_Name'];
                    $gender=$row['Gender'];
                    $dob=$row['DOB'];
                    $phn=$row['Phone'];
                    ?>
                        <h3>Update your Profile</h3>

                        User Name<input type="text" name="uname" value="<?php echo $username;?>" required>

                        <label>Email</label>
                        <input type="email"  name="email" value="<?php echo $email;?>" required>

                        <label>First Name</label>
                        <input type="text"  name="fname"   value="<?php echo $fname;?>" required>
                        <br>
                        <label>Last Name</label>
                        <input type="text"  name="lname"  value="<?php echo $lname;?>" required>
                        <br>
                        <br>
                        <label for="gender">Gender</label>
                        <input type="radio" name="gender" value="Male" required><span>Male</span>
                        <input type="radio" name="gender" value="Female" required><span>Female</span>
                        <br>
                        <label>Date</label> 
                        <input type="date" name="dob"  value="<?php echo $dob;?>" required><br>
                        <label>Phone Number</label>
                        <input type="number" name="pnumber"  value="<?php echo $phn;?>" required><br>
                        <br>
                        <input type="submit" class="btn" value="Update" name="btn-save">
                </form>
            </div>

            <?php 
            if(isset($_POST['btn-save'])){
                $username=$_POST['uname'];
                $email=$_POST['email'];
                $fname=$_POST['fname'];
                $lname=$_POST['lname'];
                $gender=$_POST['gender'];
                $dob=$_POST['dob'];
                $phn=$_POST['pnumber'];
            
                $sql="UPDATE `parent` SET `Parent_Id`='".$_SESSION['Parent_Id']."',`Email`='$email',`First_Name`='$fname',`Last_Name`='$lname',`Gender`='$gender',`DOB`='$dob',`Phone`='$phn' WHERE `Parent_Id`='".$_SESSION['Parent_Id']."'"  ;
            
                
                $result=mysqli_query($conn,$sql);
            
                if($result){
                 
    
                    echo '<script>  
                    alert("update successfully....!");
                   </script>';
                }
                else{
                    die(mysqli_error($con));
                }
            }
            ?>
            <!--change password-->
            <div class="change_password">
                <form action="" method="POST" name="myForm" onsubmit = "return(validate());">
                    <h3 style="text-align: center;color: #1c6e8c;font-size: 20px;"><b>Change password</b></h3>
                    <br>
                <?php //echo $_SESSION['Parent_Id'];
                 //echo $_SESSION['Password'];
                ?>
                    <?php if (isset($_GET['error'])) { ?>
     		        <p class="error"><?php echo $_GET['error']; ?></p>
     	            <?php } ?>

     	            <?php if (isset($_GET['success'])) { ?>
                    <p class="success"><?php echo $_GET['success']; ?></p>
                     <?php } ?>
                    <label>Current Password</label><br>
                   
                    <input type="password"  name="op" ><br><br>
                    <label>New Password</label><br><br>
                    <input type="password"  name="np" ><br>
                        <p>Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.</p>
                        <br>
                        <label>Verify</label><br><br>
                    <input type="password" name="c_np" >
                    <br><br>
                    <button type="submit" class="btn" name="btn_change_ps">Save</button><br>
                </form>
            </div>
    </div>
    <?php
    if (isset($_POST['op']) && isset($_POST['np']) && isset($_POST['c_np'])) {
   
 
    $op =$_POST['op'];
	$np = $_POST['np'];
	$c_np = $_POST['c_np'];
    $op = md5($op);
   $np = md5($np);


  $id =$_SESSION['Parent_Id'];
  echo $id;
  echo $op;
    $sql = "SELECT *
            FROM parent WHERE 
            Parent_Id='$id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);
        if ($row['Parent_Id'] === $id && $row['Password'] === $op ) {
        $sql_2 = "UPDATE parent
                  SET Password='$np'
                  WHERE Parent_Id='$id'";
        mysqli_query($conn, $sql_2);
        
        $sql_3 = "UPDATE user
                  SET Password='$np'
                  WHERE Parent_Id='$id'";
        mysqli_query($conn, $sql_3);  
       // header("Location: parent-setting.php?success=Incorrect password");
        
        echo '<script>  alert("The username is taken try another....!");</script>';
        exit();
        }
}
else {
    echo '<script>  alert("The username is taken");</script>';
    exit();
}
    
}
?>
</body>
    <script type="text/javascript">
      
    </script>
    
</html>
<?php 
}else{
    header("Location: http://localhost/First_Project/pages/login.php");
     exit();
}
 ?>