
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

	<style>
		body {
		background-color: #33CC33;
		}
	</style>
    
  </head>
  <body>
	
	<div class ="navbar navbar-inverse navbar-static-top"> 
		<!--Navigation Bar -->
		<div class = "container" role = "tabpanel">
            
            <ul class=" nav navbar-nav" role = "tablist">
			    <li role="presentation"  class = "active"   ><a href = "#BlankPage"  aria-controls="BlankPage" role="tab" data-toggle="tab">Blank Page</a></li>  <!--Creates a Blank Page. If it's save it is sent to another tab--> 
				<li role="presentation"><a href="#Tutorial"  aria-controls="Tutorial" role="tab" data-toggle="tab"> Tutorial</a></li> 
                 
			</ul> 
	
			
            <ul class=" nav navbar-nav navbar-right">
                <!--Checks to see if signed in-->
					<li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        My Account
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="MyProfile.php?username=">My Profile</a></li>
                        <li><a href="#">My Files</a></li>
                        <li><a href="index.php">Logout</a></li>
                    </ul>
				  
				
             </ul>
	
			</div>
		</div>
   
   <div class = "tab-content container" >
   
		<!--Saved Notes Tab-->
		<div role="tabpanel" class="tab-pane   " id="FileName">
							<form action="index.php?username=" method="POST" enctype="multipart/form-data"/>
								
					<h4>Title:<h4>
					<input type="text" name="title" value=""/>
					</br><textarea cols="150" rows="25" name="noteText"></textarea>
					</br><h4>Comments:<h4>
					<input type="text" name="comments" value=""/>
					<br/>
					<h4>Upload a picture of some text (must be a .png):<h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value=""/>
					<br/>	
					<input type="submit" value="save"/>
				</form>
		</div>
		
		<!--Blank Page Tab-->
		<div role="tabpanel" class="tab-pane   active "id="BlankPage">
							<form action="index.php?username=" method="POST"  enctype="multipart/form-data" />
								<h4>Title:<h4>
					<input type="text" name="title" />
					</br>
					
					<!--THE MAIN TEXTBOX-->
					</br><textarea cols="50" rows="25" name="noteText"></textarea>
					
					</br><h4>Comments on this note:<h4>
					<input type="text" cols="150" rows="3" name="comments"/>
					<br/>
					<h4>Upload a picture of text (must be .png file):<h4>
					<input type="file" name="fileToUpload" accept="image/png" id="fileToUpload"/>
					<br/>
					<input type="hidden" name="username" value=""/>
					<br/>	
					<input type="submit" value="Save"/>
				</form>
		</div>
	
		
		
	</div>
	
  </body>

    
</html>
