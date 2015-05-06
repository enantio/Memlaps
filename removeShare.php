
<?php 
include('dbConnect.php');

 if (isset($_GET['username'])) 
	 {
		$statement="select * from Note_Share where share_W_user='". $_GET["username"]."' OR share_W_user='ADMIN';";
		 $noteshare=mysqli_query($DBconnection,$statement);
			while($dataShare=mysqli_fetch_array($noteshare,MYSQL_BOTH))
				{
					if($_GET['title'] == $dataShare['title'])
					{
						$query="DELETE FROM Note_Share WHERE author='".$_GET['username']."' AND title='".$dataShare['title']."';";
						mysqli_query($DBconnection,$query);
					}
				}	
			mysqli_free_result($noteshare);	
			$myProfile = "MyProfile.php?username=".$_GET['username'];
			header('Location: '.$myProfile);
	 }
?>