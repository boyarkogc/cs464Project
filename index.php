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

 </div>
</div>

