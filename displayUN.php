<?php 
	 if(isset($_GET['username'])){
		echo $_GET['username'];
	
	 }
	 elseif(isset($_POST['username'])){
		echo $_POST['username'];
		
	}
?>
