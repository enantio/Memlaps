<?php
	
	if(isset($_POST['addAFriend']) ||isset($_GET['addAFriend']) ){
		//check friends name and use secure copy from DBconnection
		if(isset($_GET['publicPage']) || isset($_POST['publicPage']))
		include('dbConnect.php');
	
		$statement=$DBconnection->prepare("select username from User_Info where username=?;");
		$statement->bind_param('s',$_GET['addAFriend']);
		$statement->execute();
		$note=$statement->get_result();
		$FriendsName=$note->fetch_assoc();
		$statement->close();
		
		
		$statement="SELECT * FROM Friends WHERE username='".$_GET["username"]."' AND friend='".$FriendsName['username']."';";
		$friends=mysqli_query($DBconnection,$statement);
		if(mysqli_num_rows($friends)==0){
			mysqli_free_result($friends);
			$statement="INSERT INTO Friends VALUES('".$_GET["username"]."','".$FriendsName['username']."');";
			mysqli_query($DBconnection,$statement);
		}
		else{
			mysqli_free_result($friends);
		}
		if(isset($_GET['publicPage']) || isset($_POST['publicPage'])){
			$myProfile = "publicProfile.php?username=".$_GET['username']."&user=".$_GET['addAFriend'];
			header('Location: '.$myProfile);
			include('dbConnect.php');
		}
	
	}
?>
