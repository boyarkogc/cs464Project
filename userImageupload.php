<?php
	require "header.php";
	if(! isset($_SESSION['question_answer']) ){//if not fully logged in, redirect
        header("Location: " . "index.php");
        exit();
    }
	
	if (isset($_POST["submit"])) {
		$check = getimagesize($_FILES["fileToUpload"]['tmp_name']); 
		if($check !== false) {
			if ($_FILES["fileToUpload"]["size"] < 1048576) {
					//file size ok
					$whitelist = "/(182.62.*|localhost|127.0.0.1|24.9.123.78|129.82.*)/";
					if(preg_match($whitelist, $_SERVER["REMOTE_ADDR"])) {
						//everything ok
						$target_dir = "images/";
						$fullPath = $target_dir . basename(md5($_SESSION['userName'].time()));// full new filename with path
						$name = $_FILES["fileToUpload"]['name'];
						$extension = end((explode(".", $name))); # extra () to prevent notice
						if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $fullPath.".".$extension)) {
								//echo "The file ".$fullPath. " has been uploaded.";
								$databaseObj->addImage(getUserFromSession(), $fullPath.".".$extension);
								chmod($fullPath.".".$extension,0755);
						} else {
								$errors[3] = "Error: Sorry, there was an error uploading your file.";
						}
					} else {
						$errors[2] = "Error: Not part of Whitelisted IP's";
					}
			} else {
					$errors[1] = "Error: File size is to large";
			}
    } else {
			$errors[0] = "Error: File is not an Image";
		}
	} 
?>


<div class="container">
 <div class="main" >
  
  <div class="row">
  	<div class="col-md-6 col-md-offset-3">
			<h1>Image Upload</h1>
					<?php
		       	if(isset($errors)) {
		       		foreach($errors as $error) {
		       			echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
		       		}
		       	}
		       ?>
     <form method="post" action="userImageupload.php" enctype="multipart/form-data">
			<div class="form-group">
				<label for="fileToUpload">Image Upload</label>
				<input type="file" id="fileToUpload" name="fileToUpload">
			</div>
			
 			<button type="submit" class="btn btn-primary" name="submit">Submit</button>
			</form>
		</div>
	</div>
 </div>
</div>
<?php
	require "footer.php";
?>
