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

    <!--nicedit-->
    <script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
    
    <!--bootstrap-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
    <script src="js/bootstrap.js"></script>
	<script src="js/searchJava.js"></script>
  </head>
  <body>
	<div class ="navbar navbar-inverse navbar-static-top"> <!--Navigation Bar -->
		<div class = "container" role = "tabpanel">
            
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
			
			
              <?php if(isset($_POST["username"]) || isset($_GET["username"])) : ?>  <!--Checks to see if signed in-->
					<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=<?php include('displayUN.php');?>">My Profile</a></li>
                        <li><a href="index.php?signout=true">Logout</a></li>
                    </ul>
				 <?php else :?> 
					<li><a href = "memlapsSignIn.php" >Sign In</a></li>
					<li><a href ="memlapsSignUp.php">Sign Up</a></li>
				 <?php endif; ?> 
					</li>
				
             </ul>
	
		</div>
	</div>
		
	<div class = "container">
		<h1> Search Page</h1><br>
		
		<?php
		include('dbConnect.php');
		if($_GET['search'] == NULL)
			echo "<h3>Nothing matches your search</h3>";
		else if(isset($_GET['search']))
		{
			if($_GET['search_param'] == 'Notes'){
				$title = "%".$_GET['search']."%";
				$search_sql=$DBconnection->prepare("select * from Note_Share where share_W_user='ADMIN' AND title like ? order by title;");
				$search_sql->bind_param('s',$title);
			}
			else{
				$user = "%".$_GET['search']."%";
				$search_sql=$DBconnection->prepare("select * from User_Info where username like ?;");
				$search_sql->bind_param('s',$user);
			}
			$search_sql->execute();
			$search_query=$search_sql->get_result();
			
			$i = 0;
			$array =[];
			$author = [];
			
			$search = mysqli_fetch_array($search_query,MYSQL_BOTH);
			do{
				
				if($search==NULL){
					echo "<h3>Nothing matches your search</h3>";
					break;
				}
			
				if($_GET['search_param'] == 'Notes'){
					if(!in_array($search['title'], $array)){	
						$array[$i] = $search['title'];
						$author[$i] = $search['author'];
						$i++;
					}
				}
				else{
					if(!in_array($search['username'], $array)){	
						$array[$i] = $search['username'];
						$i++;
					}
			
				}
				$search = mysqli_fetch_array($search_query,MYSQL_BOTH);
				
			}
			while($search);
			
			for($i = 0; $i <count($array); $i++){
				echo "<p>";
				if($_GET['search_param'] == 'Notes')
					echo "<a href ='index.php?username=".$_GET['username']."&author=".$author[$i]."&title=".$array[$i]."'>";
				else 
					echo "<a href ='publicProfile.php?username=".$_GET['username']."&user=".$array[$i]."'>";
				echo $array[$i];
				echo "</a></p>";
			}
		//$search_sql->close();
		//mysqli_free_result($search);
		}
		?>
	</div>
	
  </body>

    
</html>
