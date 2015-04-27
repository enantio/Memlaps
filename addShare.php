
	
<?php 
include('dbConnect.php');

 if (isset($_GET['username'])) 
	 {
		$statement="INSERT INTO Note_Share VALUES('".$_GET["username"]."','".$_GET['title']."',".$_GET['share']."');";
		mysqli_query($DBconnection,$statement);
		
		$myProfile = "MyProfile.php?username=".$_GET['username'];
		header('Location: '.$myProfile);
	 }
?>