<?php
	if(isset($_POST['addAFriend'])){
		$statement="SELECT * FROM Friends WHERE username='".$_GET["username"]."' AND friend='".$_POST['addAFriend']."';";
		$friends=mysqli_query($DBconnection,$statement);
		if(mysqli_num_rows($friends)==0){
			mysqli_free_result($friends);
			$statement="INSERT INTO Friends VALUES('".$_GET["username"]."','".$_POST['addAFriend']."');";
			mysqli_query($DBconnection,$statement);
		}
		else{
			mysqli_free_result($friends);
		}
	}
?>
