<?php
// Initialize the session
session_start(); 
include "./conn.php";
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../styles/login.css">
<script>
	function validate() {
		

		var username=document.myForm.username.value ;
		var email = document.myForm.email.value;
		var user = document.myForm.User.value; 
		var password = document.myForm.password.value;
		var conpassword= document.myForm.cpassword.value;

		
		if (username==null || username==""){ 
			
			alert("Username can't be blank"); 
			document.myForm.username.focus();
			return false; 
			}
		else if (email==null || email==""){ 
			alert("Email can't be blank");
			document.myForm.email.focus(); 
			return false; 
		}
		else if (user=="0"){ 
			alert("Please Select the user role");
			document.myForm.user.focus();  
			return false; 
		}
		
		else if (password==null || password==""){ 
			alert("Please type a password"); 
			document.myForm.password.focus();
			return false;  
		}
		
		else if (password!=conpassword){ 
			alert("Confirm Password should match with the Password");
			return false;  
			
		} 
		
	}

	function validate_login(){
		var users=document.login.U_Name.value ;
		var pass = document.login.P_Word.value;
	

		
		if (users=null || users==""){ 
			
			alert("Username can't be blank"); 
			document.login.U_Name.focus();
			return false; 
			}
			else if (pass==null || pass==""){ 
			alert("Please type a password"); 
			document.login.P_Word.focus();
			return false;  
		}
	}

</script>
</head>
<body>
	<div class="container" id="container">
		<div class="form-container sign-up-container">
			<form method="POST"  name="myForm" onsubmit="return validate();">
				<h1>Create an Account</h1>
				
				<input type="text" placeholder="Username" name="username" onblur="return validate_username()"/>
				<input type="email" placeholder="Email" name="email" />
				<select name="User" id="user">
					<option value="0" name="user_role">Selected one</option>
					<option value="1" name="user_role">Parent</option>
					<option value="2" name="user_role">Teacher</option>
				</select>
				<input type="password" placeholder="Password" name="password" id="Pass" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" />
				<span id="err_pass" class="danger"></span>
				
				<input type="password" placeholder="Confirm Password" name="cpassword" />
				<button type="submit" name="reg_user">Sign Up</button>
			</form>
			
		</div>

		<!--login user-->
		<div class="form-container sign-in-container">
			<form method="POST" name="login" action="signin.php" onsubmit="return validate_login();">
				<h1>Sign in</h1>
				<span>or use your account</span>
				<?php if (isset($_GET['error'])) { ?>
     			<p class="error" style="color:red;"><?php echo $_GET['error']; ?></p>
     			<?php } ?>
				<input type="text" placeholder="Username" name="U_Name" />
				<input type="password" placeholder="Password" name="P_Word" />
				<button type="submit" name="sign_user">Sign In</button>
			</form>
		</div>
		<div class="overlay-container">
			<div class="overlay">
				<div class="overlay-panel overlay-left">
					<h1>Welcome Back!</h1>
					<p>To keep connected with us please login with your personal info</p>
					<button class="ghost" id="signIn">Sign In</button>
				</div>
				<div class="overlay-panel overlay-right">
					<h1>Hello...!</h1>
					<p>Enter your personal details and start journey with us</p>
					<button class="ghost" id="signUp">Sign Up</button>
				</div>
			</div>
		</div>
	</div>
	<?php
	//register user
	$Error= "";
	
	if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])
	&& isset($_POST['User']) && isset($_POST['cpassword'])) {
		

		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$password = mysqli_real_escape_string($conn, $_POST['password']);
		$cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
		$userrole =mysqli_real_escape_string($conn, $_POST['User']);
		// hashing the password
       // $password = md5($password);
		$sql = "SELECT * FROM user WHERE User_Name='$username' ";
		$result = mysqli_query($conn, $sql);

		if (mysqli_num_rows($result) > 0) {
			
			echo '<script>  alert("The username is taken try another....!");</script>';
			exit();
		}
		else{
			if($userrole =='1'){
			
				$query = "INSERT INTO parent (User_Name, Email, Password) VALUES('$username', '$email', '$password')";
				mysqli_query($conn, $query);
	
				$parent_check_query = "SELECT * FROM parent WHERE User_Name='$username'";
				$result_IN_Parent = mysqli_query($conn, $parent_check_query);
				$row = mysqli_fetch_array($result_IN_Parent);
				
				$Id= $row['Parent_Id'];
					
				$insert_query_user_parent="INSERT INTO user (User_Name,Password,Type,Parent_Id,Student_Id,Teacher_Id) VALUES('$username', '$password', '$userrole','$Id',NULL,NULL)";
				mysqli_query($conn, $insert_query_user_parent);
				echo '<script>  alert("register successfully....!");</script>';
				exit();
			}
			else if($userrole =='2'){
	
				
				$query_t = "INSERT INTO teacher (User_Name, Email, Password) VALUES('$username', '$email', '$password')";
				mysqli_query($conn, $query_t);
	
				$tea_check_query = "SELECT * FROM teacher WHERE User_Name='$username'";
				$result_IN_tea = mysqli_query($conn, $tea_check_query);
				
				$row_tea = mysqli_fetch_array($result_IN_tea);
				//$tea_Id =$row_tea['Teacher_Id'];
				
				
				$insert_query_user_t="INSERT INTO user (User_Name,Password,Type,Parent_Id,Student_Id,Teacher_Id) VALUES('$username', '$password', '$userrole',NULL,NULL,'".$row_tea['Teacher_Id']."')";
				mysqli_query($conn, $insert_query_user_t);
				echo '<script>  alert("register successfully....!");</script>';
				exit();
				
			}
		}
	}
	
	
	
		
	
	
	?>
</body>
<script type="text/javascript">
	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});

	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});

	
	


</script>



</html>