<?php
	session_start();
	
	/*if(empty($_SESSION["UserCheck"]))
		header("Location: memlapsSignIn.php");
	if(isset($_POST["username"]) && $_POST["username"]!=$_SESSION['name'])
		header("Location: index.php?signout=true");
	if(isset($_GET["username"]) && $_GET["username"]!=$_SESSION['name'])
		header("Location: index.php?signout=true");
*/
	?>
<!DOCTYPE html>
<html>
<head>
    <title> Memlaps </title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="css/bootstrap-arrows.css" rel="stylesheet" type="text/css" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/bootstrap-arrows.js"></script>
	
	<script src="js/confirm.js"></script>


</head>
<body>
	<?php
		include('dbConnect.php');//connect to database
		include ('addFriend.php');
    ?>
	
    <div class="navbar navbar-inverse navbar-static-top"> <!--Navigation Bar -->
        <div class="container">

            <ul class="nav navbar-form navbar-left ">
                <li><a href="index.php?username=<?php echo $_GET['username']; ?>" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</a></li>
            </ul> 
            <ul class=" nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=<?php echo $_GET['username']; ?>">My Profile</a></li>
                        <li><a href="#">My Files</a></li>
                        <li><a href="index.php">Logout</a></li>  <!--Returns you to initial blank index page-->
                    </ul>
            </ul>
        </div>
    </div>
    
    <div class = "container">
		<ul class = "list-inline">
		<li><h1><?php echo $_GET['user']; ?></h1></li>
		<li><form class action ='addFriend.php?username=<?php echo $_GET['username'];?>&addAFriend=<?php echo $_GET['user'];?>&publicPage=true' method='POST' onclick = 'return confirmFriend()'>
		<button type='submit' class = "btn btn-xs">Add Friend</button></form></li>
		</ul>
		<br><h2> Notes</h2>
		<?php
			$statement="select * from Note_Share where author='".$_GET["user"]."' AND share_W_user='ADMIN';";
				$notes=mysqli_query($DBconnection,$statement);
				
				echo "<h3>Public Notes.</h3>";
				if (mysqli_num_rows($notes)==0) { 
					echo "They are not sharing any note files.";
				}	
				else{
						echo "</br><table class = 'table table-hover'>";//Basic table
						echo "<thead>";
							echo "<th>File Name</th>";
							echo "<th>Author</th>"	;
							echo "<th>Shared User</th>";
						echo "</thead>";
						echo "<tbody>";
							while($dataRow=mysqli_fetch_array($notes,MYSQL_BOTH)){
									//temporary
									echo "<tr><td><a href='index.php?username=".$_GET['username']."&author=".$dataRow['author']."&title=".$dataRow['title']."'>";
									echo $dataRow['title'];
									echo "</a></td><td><a href='index.php?username=".$_GET['username']."&author=".$dataRow['author']."&title=".$dataRow['title']."'>";
									echo $dataRow['author'];
									echo "</a></td><td><a href='index.php?username=".$_GET['username']."&author=".$dataRow['author']."&title=".$dataRow['title']."'>";
									if($dataRow['share_W_user']=="ADMIN")echo "Public";
									else echo $dataRow['share_W_user'];
									echo "</a></td></tr>";
							}
						echo "</tbody>";
					echo "</table>";
					mysqli_free_result($notes);
				}
			
		?>

</div>
