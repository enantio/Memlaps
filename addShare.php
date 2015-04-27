
	
<?php 
include('dbConnect.php');

 if (isset($_GET['username'])) 
	 {
		 $username = $_GET["username"];
		 $title = $_GET['title'];
		 $share = $_GET['share'];
		$query="INSERT INTO Note_Share VALUES('$username', '$title', '$share')";
		mysqli_query($DBconnection,$query);
		
		$myProfile = "MyProfile.php?username=".$_GET['username'];
		header('Location: '.$myProfile);
	 }
?>