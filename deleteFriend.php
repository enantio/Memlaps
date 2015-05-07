<?php 
include('dbConnect.php');

 if (isset($_GET['username'])) 
	 {
		$query="DELETE FROM Friends WHERE username='".$_GET['username']."' AND friend='".$_GET['friend']."';";
		mysqli_query($DBconnection,$query);
		$myProfile = "MyProfile.php?username=".$_GET['username'];
		header('Location: '.$myProfile);
	 }
?>