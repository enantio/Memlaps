<?php
	session_start();
	if(isset($_GET["signout"])){
		session_unset();
		session_destroy();
	}
	if(empty($_SESSION["UserCheck"]))
		header("Location: memlapsSignIn.php");
?>

<!DOCTYPE html>
<html>
  <head>
    <title> Memlaps </title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <!--nicedit-->
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    
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
										<span id="search_concept">All</span> <span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li><a href="#Notes">Notes</a></li>
										<li><a href="#Users">Users</a></li>
										<li class="divider"></li>
										<li><a href="#All">All</a></li>
									</ul>
									<input type="hidden" name="search_param" value="All" id="search_param">
									<input type="hidden" name="username" value="<?php include('displayUN.php');?>">   
								</div>
								
								<input type="text" name ="search"class="form-control" placeholder="Search">
								<span class="input-group-btn">
									<button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
								</span>
							</div>
						</div>
					</form>
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
		<h1> Search Page</h1>
		
		<?php
		include('dbConnect.php');
		if($_GET['search'] == NULL)
			echo "<h3>Nothing matches your search</h3>";
		else if(isset($_GET['search']))
		{
			if($_GET['search_param'] == 'All')
			{
				$search_sql = "select * from Notes where author like '%". $_GET['search']."%' or author like '%". $_GET['search']."%'";
			}
			else if($_GET['search_param'] == 'Notes')
			{
				$search_sql = "select * from Notes where title like '%". $_GET['search']."%'";
			}
			else{
				$search_sql = "select * from Notes where author like '%". $_GET['search']."%'";
			}
			$search_query = mysqli_query($DBconnection,$search_sql);

			if(mysqli_num_rows($search_query)==0){
				echo "<h3>Nothing matches your search</h3>";
			}
			else{
				$i = 0;
				$array =[];
				while($search = mysqli_fetch_array($search_query,MYSQL_BOTH))
				{
					if($_GET['search_param'] == 'All'){
						if(!in_array($search['author'], $array)){	
							$array[$i] = $search['author'];
							$i++;
						}
						if(!in_array($search['title'], $array)){	
							$array[$i] = $search['title'];
							$i++;
						}
					}
					else if($_GET['search_param'] == 'Notes'){
						if(!in_array($search['title'], $array)){	
							$array[$i] = $search['title'];
							$i++;
						}
					}
					else{
						if(!in_array($search['author'], $array)){	
							$array[$i] = $search['author'];
							$i++;
						}
						
					}
					
				}
				natsort($array);
				for($i = 0; $i <count($array); $i++)
				{
					echo "<p>";
					echo $array[$i];
					echo "</p>";
				}
			}
		}
		?>
	</div>
	
  </body>

    
</html>
