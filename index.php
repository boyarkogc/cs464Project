<?php	
	require "header.php";

	if(isset($_POST['userName']) && isset($_POST['password'])) {

		$user = $databaseObj->findUser(sanitize($_POST["userName"]),sanitize($_POST["password"]) ) ;


		if(is_null($user)) {
			$errors[0] = "Error: Username and Password is invalid!";

		} else {
			//user exists
				logUserIn($user);		
				header("Location: " . "verify.php");
					return;
				
			} 
		
	}
?>
<div class="container">
      <div class="main" >
			<?php
				if(!isset($_SESSION['userName'] ) ){
				?>
        <h1 style="text-align:center;">Log In</h1>
        <div class="row">
        	 <div class="col-md-6 col-md-offset-3">
					
		       <form method="post" action="index.php">
		       	<?php
		       	if(isset($errors)) {
		       		foreach($errors as $error) {
		       			echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
		       		}
		       	}
		       ?>
				  <div class="form-group">
				    <label>User Name:</label>
				    <?php
				    	if(isset($inputUserName) || !empty($inputUserName)) {
				    		echo "<input type=\"text\" class=\"form-control\" name=\"userName\" value=\"$inputUserName\">";
				    	} else {
				    		?>
				    			 <input type="text" class="form-control" name="userName" placeholder="Enter User Name" required>
				    		<?php
				    	}
				    ?>
				  </div>
				  <div class="form-group">
				    <label>Password</label>
				    <?php
				    	if(isset($inputPassword)) {
				    		echo "<input type=\"password\" class=\"form-control\" name=\"password\" value=\"$inputPassword\">";
				    	} else {
				    		?>
				    			<input type="password" class="form-control" name="password" placeholder="Password" required>
				    		<?php
				    	}
				    ?>
				  </div>
				  <button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
		<?php } ?>
		</div>
		<div class="row" style="margin-top:15px;">
		<h1 style="text-align:center;">All Users</h1>
		<?php
			$allUsers = $databaseObj->getUsers();
			foreach($allUsers as $singleUser) {
		?>
      <div class="col-md-2">
				<?php 
					if(is_null($singleUser->imageLocation)) {
						//no profile image selected, use random if possible, else use default
						$user = $databaseObj->getUser($singleUser->userName);
						$imageData = $databaseObj->getUserImages($user);
						if($imageData !== false) {
							//then we have images
							echo "<a href=\"profile.php?userName=".$user->userName."\"><img src=\"".$imageData[0]."\" style=\"max-width:100%;\"alt=\"".$user->userName."'s Profile Image\" class=\"img-rounded\"></a>";
						} else {//no uploaded images for user
							echo "<a href=\"profile.php?userName=".$user->userName."\"><img src=\"images/defaultprofile.jpg\" style=\"max-width:100%;\"alt=\"".$user->userName."'s Profile Image\" class=\"img-rounded\"></a>";
						}
					} else {
						//use user profile image
						$user = $databaseObj->getUser($singleUser->userName);
						echo "<a href=\"profile.php?userName=".$user->userName."\"><img src=\"".$databaseObj->getUserProfileImage($user->userName)."\" style=\"max-width:100%;\"alt=\"".$user->userName."'s Profile Image\" class=\"img-rounded\"></a>";
					}
				?>
			</div>
		<?php } ?>
		</div>
 </div>
</div>
<?php
	require "footer.php";
?>
