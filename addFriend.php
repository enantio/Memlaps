<?php
	if(isset($_POST['addAFriend'])){
		//check friends name and use secure copy from DBconnection
		$statement=$DBconnection->prepare("select username from User_Info where username=?;");
		$statement->bind_param('s',$_POST['addAFriend']);
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
	}
?>
