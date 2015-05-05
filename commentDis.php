<?php 
	if(!isset($_GET['title']) && !isset($_POST['title']))
		echo"";
	else{
		$statement=$DBconnection->prepare("select comments from Notes where author=? and title=?;");
		if(isset($_GET['comments'])){
			$statement->bind_param('ss', $_GET['username'],$_GET['title']);
		}
		elseif(isset($_POST['comments'])){
			$statement->bind_param('ss', $_GET['username'],$_POST['title']);
		}
		elseif(isset($_GET['author'])){
			$statement->bind_param('ss', $_GET['author'],$_GET['title']);
		}
		$statement->execute();
		$note=$statement->get_result();
		$dataRow=$note->fetch_assoc();
		echo $dataRow['comments'];
		$statement->close();
	}
?>
