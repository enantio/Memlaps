
<?php 
include('dbConnect.php');

 if (isset($_GET['username'])) 
	 {
		$statement="select * from Note_Share where author='". $_GET["username"]."'";
		$noteshare=mysqli_query($DBconnection,$statement);
			while($dataShare=mysqli_fetch_array($noteshare,MYSQL_BOTH))
				{
					
					if($_GET['title'] == $dataShare['title'])
					{
						$query="DELETE FROM Note_Share WHERE author='".$_GET['username']."' AND title='".$dataShare['title']."'AND share_W_user='".$dataShare['share_W_user']."';";
						mysqli_query($DBconnection,$query);
					}
				}	
			$query="DELETE FROM Notes WHERE author='".$_GET['username']."' AND title='".$_GET['title']."';";
			mysqli_query($DBconnection,$query);
			mysqli_free_result($noteshare);
			$myProfile = "MyProfile.php?username=".$_GET['username'];
			header('Location: '.$myProfile);
	 }
?>