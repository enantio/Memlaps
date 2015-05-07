<?php
	session_start();
	
	if(empty($_SESSION["UserCheck"]))
		header("Location: memlapsSignIn.php");
	if(isset($_POST["username"]) && $_POST["username"]!=$_SESSION['name'])
		header("Location: index.php?signout=true");
	if(isset($_GET["username"]) && $_GET["username"]!=$_SESSION['name'])
		header("Location: index.php?signout=true");
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
	<script src="js/confirm.js"></script>
    <script type="text/javascript" src="js/bootstrap-arrows.js"></script>
	
	
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
				<li>
				<form class="navbar-form" action ="searchPage.php"> <!--Search Bar-->
						<div class="form-group" style="display:inline;">
							<div class="input-group"> 
								<div class="input-group-btn search-panel">
									<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span id="search_concept">Notes</span> <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#Notes">Notes</a></li>
										<li><a href="#Users">Users</a></li>
									</ul>
									<input type="hidden" name="search_param" value="Notes" id="search_param">   
									<input type="hidden" name="username" value="<?php include('displayUN.php');?>">   
								</div>
								
								<input type="text" name ="search"class="form-control" placeholder="Search">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
								</span>
							</div>
						</div>
					</form>  
					<!-- End of Search Bar-->
				</li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=<?php echo $_GET['username']; ?>">My Profile</a></li>
                        <li><a href="index.php?signout=true">Logout</a></li>  <!--Returns you to initial blank index page-->
                    </ul>
            </ul>

        </div>
    </div>
    
    <div class = "container">
		<h1> Notes</h1>
		<?php
			
			//display all user's saved notes
			if($_GET!=NULL){
			
				$statement="select * from Notes where author='". $_GET["username"]."';";
				$notes=mysqli_query($DBconnection,$statement);
				
				$statement="select * from Note_Share where share_W_user='". $_GET["username"]."' OR share_W_user='ADMIN';";
				$noteshare=mysqli_query($DBconnection,$statement);
				
				echo "<h3>Your Notes</h3></br>";
				if (mysqli_num_rows($notes)==0) { 
					echo "You do not have any note files saved.";
				}	
				else{
					echo "<table class = 'table table-hover'>";//Basic table
					echo "<thead>";
						echo "<th>File Name</th>";
						echo "<th>Author</th>"	;
						echo "<th>Date of Creation</th>";
					echo "</thead>";
					echo "<tbody>";
					$i = 0;
						while($dataRow=mysqli_fetch_array($notes,MYSQL_BOTH)){
								//temporary
								echo "<tr><td><a href='index.php?username=".$dataRow['author']."&title=".$dataRow['title']."&comments=".$dataRow['comments']."'>";
								echo $dataRow['title'];
								echo "</a></td><td><a href='index.php?username=".$dataRow['author']."&title=".$dataRow['title']."&comments=".$dataRow['comments']."'>";
								echo $dataRow['author'];
								echo "</a></td><td>";
								echo $dataRow['last_mod'];
								echo "</td><td>";
								echo "<form action ='deleteNotes.php?username=".$dataRow['author']."&title=".$dataRow['title']."' method='POST'";
								echo "onclick = 'return confirmDelete()'>";
								echo "<input type='submit' value='Delete'/></form>";
								echo "</td><td>";
								echo "<a class='btn btn-primary' data-toggle='modal' href ='#".$i."'>Share</a></td></tr>";
								
									//Modal Dialog 
								echo "<div class='modal fade' id='".$i."' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";						
									echo "<div class='modal-dialog'>";
										echo "<div class='modal-content'>";
											echo "<div class='modal-header' style = 'background-color: #337ab7'>";
												echo "<h4 class='modal-title' style = 'color: white'>Share</h4>";
											echo "</div>";
											echo "<div class='modal-body'>";
												echo "<h2>Post to Public</h2>";
												echo "<div class ='container'>";
													echo "<a class='btn btn-primary' href ='addShare.php?username=".$dataRow['author']."&title=".$dataRow['title']."&share=ADMIN'>Public</a>";
												echo "</div>";
												
												$statement="SELECT * FROM Friends WHERE username='".$_GET["username"]."';";
												$friends=mysqli_query($DBconnection,$statement);
		
												echo "<hr><h3>Share with Friends</h3>";
												if (mysqli_num_rows($friends)==0) { 
													echo "You have no friends.";
												}
												else{
													echo "<div class ='container'>";
														while($friend=mysqli_fetch_array($friends,MYSQL_BOTH)){
															echo "<p><a href = 'addShare.php?username=".$dataRow['author']."&title=".$dataRow['title']."&share=".$friend['friend']."'>";
															echo $friend['friend'];
															echo "</a></p>";
														}
													echo "</div>";
												}
												mysqli_free_result($friends);	
					
											echo "</div>";
											echo "<div class='modal-footer'>";
												echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
											echo "</div>";
										echo "</div>";
									echo "</div>";
								echo "</div>";
								//End of Modal
							$i++;
						}
					echo "</tbody>";
					echo "</table></br>";
				}
				mysqli_free_result($notes);	
				mysqli_free_result($noteshare);	
				//notes shared with user table
				$statement="select * from Note_Share where share_W_user='". $_GET["username"]."' OR share_W_user='ADMIN';";
				$notes=mysqli_query($DBconnection,$statement);
				
				echo "</br><h3>Notes shared with you.</h3>";
				if (mysqli_num_rows($notes)==0) { 
					echo "You do not have any note files shared with you.";
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
									echo "</a></td><td>";
									if ($_GET['username'] != $dataRow['author'])
										echo "<a href='publicProfile.php?username=".$_GET['username']."&user=".$dataRow['author']."'>";
									else 
										echo "<a href='index.php?username=".$_GET['username']."&author=".$dataRow['author']."&title=".$dataRow['title']."'>";
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
				//notes shared by user table
				$statement="select * from Note_Share where author='".$_GET["username"]."';";
				$notes=mysqli_query($DBconnection,$statement);
				
				echo "</br><h3>Notes shared by you.</h3>";
				if (mysqli_num_rows($notes)==0) { 
					echo "You are not sharing any note files.";
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
								echo "</a></td><td><a href='publicProfile.php?username=".$_GET['username']."&user=".$dataRow['share_W_user']."'>";
								if($dataRow['share_W_user']=="ADMIN")echo "Public";
								else echo $dataRow['share_W_user'];
								echo "</td><td>";
								echo "<form action ='removeShare.php?username=".$dataRow['author']."&title=".$dataRow['title']."&share=".$dataRow['share_W_user']."' method='POST'";
								echo "onclick = 'return confirmUnshare()'>";
								echo "<input type='submit' value='Unshare'/></form></td>";
								echo "</tr>";
							}
						echo "</tbody>";
					echo "</table>";
					mysqli_free_result($notes);
				}
			}
	?>
	</div>
	<div class = "container"><!--friends div-->
	
	<?php
		$statement="SELECT * FROM Friends WHERE username='".$_GET["username"]."';";
		$friends=mysqli_query($DBconnection,$statement);
		
		echo "</br><h3>Your Friends</h3>";
		if (mysqli_num_rows($friends)==0) { 
			echo "You have no friends.";
		}
			 
		else{
			echo "</br><table class = 'table table-hover'>";//Basic table
			echo "<thead>";
				echo "<th>Username</th>";
			echo "</thead>";
			echo "<tbody>";
				while($dataRow=mysqli_fetch_array($friends,MYSQL_BOTH)){
						//temporary
						echo "<tr><td><a href ='publicProfile.php?username=".$_GET['username']."&user=".$dataRow['friend']."'>";
						echo $dataRow['friend'];
						echo "</td><td>";
						echo "<form action ='deleteFriend.php?username=".$_GET['username']."&friend=".$dataRow['friend']."' method='POST'";
						echo "onclick = 'return confirmUnfriend()'>";
						echo "<input type='submit' value='Unfriend'/></form></td>";
						echo "</tr>";
				}
			echo "</tbody>";
			echo "</table>";
		}
		mysqli_free_result($friends);
	?>
	
	<form role = "form" action="MyProfile.php?username=<?php echo $_GET['username']; ?>" method="POST"/>
		<div class = "form-group">
			</br>	
			<input type="text" name="addAFriend" placeholder ="New Friend's Name Here"/>
			</br>
		</div>
		<button type="submit" class="btn btn-default btn-sm">Add Friend</button>
	</form>
	</div>
	
	
</body>


</html>
