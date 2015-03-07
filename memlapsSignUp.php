<?php
	$error=0;
	if($_POST!=NULL){
		
		include('dbConnect.php');//check for accounts using the desired email and username
		$query="select * from User_Info where username='".$_POST['username']."' OR email='".$_POST['email']."';";
		$UserInfo=mysqli_query($DBconnection,$query);		
		$dataRow=mysqli_fetch_array($UserInfo,MYSQL_BOTH);
		
		if($dataRow===NULL){
			mysqli_free_result($UserInfo);
			$salt="$2y$09$".time()."00".time()."$";//create salt
			$passHash=crypt($_POST['password'],$salt);//get password hash
			$query="INSERT INTO User_Info VALUES('".$_POST['username']."','".$_POST['email']."','".$_POST['name']."','".$passHash."');";
			mysqli_query($DBconnection,$query);//create account
			$redirect="Location: index.php?username=".$_POST['username'];
			header($redirect);//this function must execute before any html
		}
		else{
			mysqli_free_result($UserInfo);
			$error=1;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		
		<title> Memlaps </title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link href="css/bootstrap-arrows.css" rel="stylesheet" type="text/css" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="js/bootstrap.js"></script>
		<script type="text/javascript" src="js/bootstrap-arrows.js"></script>

	</head>
	<body>

		<div class = "container">
			<h1>Create an account</h1>
			<?php if($error===1) ://error message for username/email duplicate ?>
				<h3>The username or email you entered has already been already taken.</h3>
			<?php endif; ?>
			<form role = "form" action="memlapsSignUp.php" method="POST"/>
				<div class = "form-group">
				
					<input type="text" name="username" placeholder ="Username"/>
					</br>
					<input type="text" name="password" placeholder="Password"/>
					</br>
					<input type="text" name="name" placeholder="your name here"/>
					</br>
					<input type="text" name="email" placeholder="memlaps@example.com"/>
				
				</div>
				<button type="submit" class="btn btn-default btn-sm">Sign Up</button>
		
			</form>
		</div>

	</body>
</html>
