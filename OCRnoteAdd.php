<?php
		$upload="/var/www/html/uploads/".$_FILES["fileToUpload"]["name"];
		require_once 'TesseractOCR.php';
		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $upload);
		$tesseract = new TesseractOCR($upload);
		$tesseract->setLanguage('eng'); 
		if (isset($_POST['noteText']))$savedNotes=$_POST['noteText'];
		else $savedNotes=$_POST['blankText'];
		$savedNotes.=$tesseract->recognize();
		unlink($upload);
?>
