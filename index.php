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

	<!--search script-->
	<script src="js/searchJava.js"></script>
	
	<!--tab.js-->
   <script src="tab.js"></script>
   
   <!--bgroundClasses.js-->
   <script src="bgroundClasses.js"></script>
   
    
  </head>
  <body>
	<?php
		include('dbConnect.php');
		if(isset($_POST['noteText'])){
			if(!isset($_GET['author']))$author=$_POST['username'];
			else $author=$_GET['author'];
			$statement="select * from Notes where author='".$author."' and title='". $_POST["title"]."';";
			
			$note=mysqli_query($DBconnection,$statement);
			$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
			 
			//check for uploaded file
			if(isset($_FILES['fileToUpload'])){
				include('OCRnoteAdd.php');			
			}
			else $savedNotes=$_POST['noteText'];
			if(!$dataRow){//check for existing note page
				mysqli_free_result($note);
				$statement="INSERT INTO Notes VALUES('".$_POST['title']."','".$author."','".$_POST['comments']."','".$savedNotes."','".date("r")."','meta stuff');";
				mysqli_query($DBconnection,$statement);
			}
			else{
				mysqli_free_result($note);
				$statement="UPDATE Notes SET notes='".$savedNotes."', title='".$_POST['title']."', comments='".$_POST['comments']."' WHERE author='".$author."' and title='". $_POST['title']."';";
				mysqli_query($DBconnection,$statement);
			}
		}
    ?>
	<div class ="navbar navbar-inverse navbar-static-top"> <!--Navigation Bar -->
		<div class = "container" role = "tabpanel">
            
            <ul class=" nav navbar-nav" role = "tablist">
			    <li role="presentation" <?php if(!isset($_POST["title"]) && !isset($_GET["title"])):?> class = "active" <?php endif; ?>  ><a href = "#BlankPage"  aria-controls="BlankPage" role="tab" data-toggle="tab">Blank Page</a></li>  <!--Creates a Blank Page. If it's save it is sent to another tab--> 
                <?php if	(isset($_POST["title"]) || isset($_GET["title"]))  :?><li role="presentation" class = "active"><a href="#FileName"  aria-controls="FileName" role="tab" data-toggle="tab"><?php include('titleDis.php'); ?></a></li> <!--If a file is opened it creates a new tab-->
				<?php endif; ?> 
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
   
   <div class = "tab-content container" >
   
		<!--Saved Notes Tab-->
		<div role="tabpanel" class="tab-pane  <?php if(isset($_POST["title"]) || isset($_GET["title"])):?>active<?php endif; ?> " id="FileName">
			<?php if(!isset($_GET['author'])) :?>
				<form action="index.php?username=<?php include('displayUN.php');?>" method="POST" enctype="multipart/form-data"/>
			<?php else:?>
				<form action="index.php?username=<?php include('displayUN.php'); echo "&author=".$_GET['author'];?>" method="POST" enctype="multipart/form-data"/>
			<?php endif; ?>
					
					<h4>Title:<h4>
					<input type="text" id="entitled" name="title" value="<?php include('titleDis.php'); ?>"/>
					</br><textarea id="THE_BOX cols="186" rows="25" name="noteText"><?php include('noteDisplay.php'); ?></textarea>
					</br><h4>Comments:<h4>
					<input type="text" name="comments" value="<?php include('commentDis.php'); ?>"/>
					<br/>
					<h4>Upload a picture of some text (must be a .png):<h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
					<br/>	
					<input type="button" value="Save" onclick="checkTitleAndSave()">
				</form>
		</div>
		
		<!--Blank Page Tab-->
		<div role="tabpanel" class="tab-pane  <?php if(!isset($_POST["title"]) && !isset($_GET["title"])):?> active <?php endif; ?>"id="BlankPage">
			<?php if(!isset($_GET['author'])) :?>
				<form action="index.php?username=<?php include('displayUN.php');?>" method="POST"  enctype="multipart/form-data" />
			<?php else:?>
				<form action="index.php?username=<?php include('displayUN.php'); echo "&author=".$_GET['author'];?>" method="POST" enctype="multipart/form-data"/>
			<?php endif; ?>
					<h4>Title:<h4>
					<input id="entitled" type="text" name="title" />
					<br/>
					</br><textarea id="THE_BOX" cols="186" rows="25" name="noteText"></textarea>
					</br><h4>Comments:<h4>
					<input type="text" name="comments"/>
					<br/>
					<h4>Upload a picture of some text (must be a .png):<h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
					<br/>	
					<input type="button" value="Save" onclick="checkTitleAndSave()">
				</form>
		</div>
		
	</div>
	
	<div id="infoBox">
		
	<h4> Keyboard Macros:</h4><p>1. Save = CTRL + s<br/>2. Change Background = CTRL + 0-9<br/>3. Change Editor Background = CTRL + q</p>
	</div>

	
   
  </body>

    
</html>

