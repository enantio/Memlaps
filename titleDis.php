<?php 
	 if(isset($_GET['title'])){
		echo $_GET['title'];
	 }
	 elseif(isset($_POST['title'])){
		echo $_POST['title'];
	}
?>
