<?php
	$error=0;
	if($_POST!=NULL){//check sign in info
		
		include('dbConnect.php');
		$query="select * from User_Info where username='".$_POST['username']."';";
		$UserInfo=mysqli_query($DBconnection,$query);		
		$dataRow=mysqli_fetch_array($UserInfo,MYSQL_BOTH);
		//if account exists and password is correct
		if($dataRow!==NULL && $dataRow['password_hash']===crypt($_POST['password'],$dataRow['password_hash'])){
			mysqli_free_result($UserInfo);
			$redirect="Location: index.php?username=".$_POST['username'];
			header($redirect);//this function must be executed before any html
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
		<title>Sign In</title>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
        <div id="signInDiv" class = "container">
			<h1>Welcome to MemLapse!<br><br>Sign in?<br></h1>
			
			<?php if($error===1)://error message for incorrect login info ?>
				<h4>Incorrect username or password</h4>
			<?php endif; ?>
			<form role = "form" action="memlapsSignIn.php" method="POST"/>
				<div class = "form-group">
					<input type="text" name="username" placeholder ="Username"/>
				</div>
				<div class = "form-group">
					<input type="password" name="password" placeholder="Password"/>
				</div>
				<button type="submit" class="btn btn-default btn-sm">Begin</button>
				
			</form>
		</div>
		
	</body>
</html>
