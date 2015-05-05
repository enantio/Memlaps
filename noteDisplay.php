<?php 
	 if(isset($_GET['title'])){
		$statement=$DBconnection->prepare("select notes from Notes where author=? and title=?;");
		if(!isset($_GET['author']))$statement->bind_param('ss', $_GET['username'],$_GET['title']);
		else $statement->bind_param('ss', $_GET['author'],$_GET['title']);
		$statement->execute();
		$note=$statement->get_result();
		$dataRow=$note->fetch_assoc();
		echo $dataRow['notes'];
		$statement->close();
	 }
	 elseif(isset($_POST['title'])){
		 $statement=$DBconnection->prepare("select notes from Notes where author=? and title=?;");
		if(!isset($_GET['author']))$statement->bind_param('ss', $_GET['username'],$_POST['title']);
		else $statement->bind_param('ss', $_GET['author'],$_POST['title']);
		$statement->execute();
		$note=$statement->get_result();
		$dataRow=$note->fetch_assoc();
		echo $dataRow['notes'];
		$statement->close();
	}
?>
