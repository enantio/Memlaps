<?php 
	 if(isset($_GET['comments'])){
		$statement="select comments from Notes where author='". $_GET["username"]."' and title='". $_GET["title"]."';";
		$note=mysqli_query($DBconnection,$statement);
		$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
		echo $dataRow['comments'];
		mysqli_free_result($note);
	 }
	 elseif(isset($_POST['comments'])){
		$statement="select comments from Notes where author='". $_GET["username"]."' and title='". $_POST["title"]."';";
		$note=mysqli_query($DBconnection,$statement);
		$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
		echo $dataRow['comments'];
		mysqli_free_result($note);
	}
?>
