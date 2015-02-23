<!DOCTYPE html>
<html>
  <head>
    <title> Memlaps </title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script> 
    <script src="js/bootstrap.js"></script>

    
  </head>
  <body>
	<?php
      include('dbConnect.php');
		if(isset($_POST['noteText'])){
			$statement="select * from Notes where author='". $_POST["username"]."' and title='". $_POST["title"]."';";
			$note=mysqli_query($DBconnection,$statement);
			$dataRow=mysqli_fetch_array($note,MYSQL_BOTH);
			
			if(!$dataRow){//check for existing note page
				mysqli_free_result($note);
				$statement="INSERT INTO Notes VALUES('".$_POST['title']."','".$_POST['username']."','".$_POST['comments']."','".$_POST['noteText']."','".date("r")."','meta stuff');";
				mysqli_query($DBconnection,$statement);
			}
			else{
				mysqli_free_result($note);
				$statement="UPDATE Notes SET notes='".$_POST['noteText']."', title='".$_POST['title']."', comments='".$_POST['comments']."' WHERE author='". $_POST['username']."' and title='". $_POST['title']."';";
				mysqli_query($DBconnection,$statement);
				
				
			}
		}
    ?>
	<div class ="navbar navbar-inverse navbar-static-top">
		<div class = "container">
            
            <ul class=" nav navbar-nav navbar-left ">
			    <li><a href = "#" class = "">Blank Page</a></li>
                <li><a href="#" class="">Tutorial</a></li>
                <li><a href="#" class="">File Name</a></li>
            </ul> 

            <ul class=" nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=<?php include('displayUN.php');?>">My Profile</a></li>
                        <li><a href="#">My Files</a></li>
                        <li><a href="memlapsSignIn.html">Logout</a></li>
                    </ul>
             </ul>

        </div>
	</div>
    
    
    <div><!--main note div-->
		<form action="index.php?username=<?php include('displayUN.php');?>" method="POST"/>
			<textarea cols="150" rows="25" name="noteText"><?php include('noteDisplay.php'); ?></textarea>
			</br><h4>Title:<h4>
			<input type="text" name="title" value="<?php include('titleDis.php'); ?>"/>
			</br><h4>Comments:<h4>
			<input type="text" name="comments" value="<?php include('commentDis.php'); ?>"/>
			<br/>
			<input type="hidden" name="username" value="<?php include('displayUN.php');?>"/>
			<br/>	
			<input type="submit" value="save"/>
        </form>
	</div>
	
  </body>

    
</html>
