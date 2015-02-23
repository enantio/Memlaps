<?php 
	 if(isset($_GET['title'])){
		$statement="select notes from Notes where author='". $_GET['username']."' and title='". $_GET['title']."';";
		$note=mysqli_query($DBconnection,$statement);
		$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
		echo $dataRow['notes'];
		mysqli_free_result($note);
	 }
	 elseif(isset($_POST['title'])){
		$statement="select notes from Notes where author='". $_GET['username']."' and title='". $_POST['title']."';";
		$note=mysqli_query($DBconnection,$statement);
		$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
		echo $dataRow['notes'];
		mysqli_free_result($note);
	}
?>
