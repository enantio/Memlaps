<?php
	session_start();
	if(isset($_GET["signout"])){
		session_unset();
		session_destroy();
	}
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
    <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
    <script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
    
    <!--bootstrap-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
    <script src="js/bootstrap.js"></script>

	<!--search script-->
	<script src="js/searchJava.js"></script>
	
	<!--tab.js-->
   <script src="tabs.js"></script>
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script> 

   
    
  </head>
  <body>
	<?php
		include('dbConnect.php');
		if(isset($_POST['blankText']) || isset($_POST['noteText']) ){
			if(!isset($_GET['author']))$author=$_POST['username'];
			else $author=$_GET['author'];
			$statement=$DBconnection->prepare("SELECT * FROM Notes WHERE author='".$author."' and title= ?;");
			$statement->bind_param('s',$_POST["title"]);
			$statement->execute();
			$note=$statement->get_result();
			$dataRow=$note->fetch_assoc();
			//check for uploaded file
			if(isset($_FILES['fileToUpload'])){
				include('OCRnoteAdd.php');			
			}
			else if (isset($_POST['noteText']))$savedNotes=$_POST['noteText'];
			else $savedNotes=$_POST['blankText'];
			if(!$dataRow){//check for existing note page
				$statement->close();
				$statement=$DBconnection->prepare("INSERT INTO Notes VALUES(?,?,?,?,'".date("r")."','meta stuff');");
				$statement->bind_param('ssss',$_POST['title'],$author,$_POST['comments'],$savedNotes);
				$statement->execute();
				$statement->close();
			}
			else{
				$statement->close();
				$statement=$DBconnection->prepare("UPDATE Notes SET notes=?, title=?, comments=? WHERE author=? and title=?;");
				$statement->bind_param('sssss',$savedNotes,$_POST['title'],$_POST['comments'],$author,$_POST['title']);
				$statement->execute();
				$statement->close();
			}
		}
    ?>
	<div class ="navbar navbar-inverse navbar-static-top"> <!--Navigation Bar -->
		<div class = "container" role = "tabpanel">
            
            <ul class=" nav navbar-nav" role = "tablist">
			    <li><h1 id="front">Memlaps</h1>	</li>
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
		
		<!--Saved Notes Tab--> <?php if(isset($_POST["title"]) || isset($_GET["title"])):?>
		<div role="tabpanel" class="tab-pane active" id="FileName">
			<?php if(!isset($_GET['author'])) :?>
				<form action="index.php?username=<?php include('displayUN.php');?>" method="POST" enctype="multipart/form-data">
			<?php else:?>
				<form action="index.php?username=<?php include('displayUN.php'); echo "&author=".$_GET['author'];?>" method="POST" enctype="multipart/form-data">
			<?php endif; ?>
					
					<h4>Title:</h4>
					<input type="text" id="entitled" name="title" value="<?php include('titleDis.php'); ?>"/>
					<br/>
					<br/><textarea id="THE_BOX" cols="186" rows="25" name="noteText"><?php include('noteDisplay.php'); ?></textarea>
					<br/><h4>Comments:</h4>
					<input type="text" name="comments" style="width: 650px;" value="<?php include('commentDis.php'); ?>"/>
					<br/>
					<h4>Upload a picture of some text (must be a .png):</h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
					<br/>	
					<input type="submit" value="Save"/>
				</form>
		</div>
		<?php endif; ?> 
		
		<!--Blank Page Tab-->
		<div role="tabpanel" class="tab-pane <?php if(!isset($_POST["title"])&& !isset($_GET["title"])):?> active <?php endif; ?>"id="BlankPage">
				<form action="index.php?username=<?php include('displayUN.php');?>" method="POST"  enctype="multipart/form-data" >
					<h4>Title:</h4>
					<input id="entitled" type="text" name="title" />
					<br/>
					<br/><textarea id="THE_BOX" cols="186" rows="25" name="blankText"></textarea>
					<br/><h4>Comments:</h4>
					<input type="text" name="comments" style="width: 650px;"/>
					<br/>
					<h4>Upload a picture of some text (must be a .png):</h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
					<br/>	
					<input type="submit" value="Save"/>
				</form>
		</div>
		
	</div>
	
	<div id="infoBox">
		
	<h4> Keyboard Macros:</h4><p>2. CTRL + 0-9 = Change Background<br/>3. CTRL + e = Change Editor Background</p>
	</div>
	
   
  </body>
    
</html>
