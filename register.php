<?php
	require "header.php";
	if(!isLoggedIn()) {
		header("Location: " . "index.php");
		die();
	} else {
    //logged in
		if($_SESSION['is_admin'] != 1) {// not an admin
			header("Location: " . "index.php");
			die();
		}
	}
	if(isset($_POST['userName'])) {
		if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['gender']) && isset($_POST['password']) &&
			isset($_POST['phoneNumber']) && isset($_POST['email']) && isset($_POST['securityQuestion']) && isset($_POST['securityAnswer'])) {
			$firstName = sanitize($_POST['firstName']);
			$lastName = sanitize($_POST['lastName']);
			$userName = sanitize($_POST['userName']);
			$gender = sanitize($_POST['gender']);
			$mobileNumber = sanitize($_POST['phoneNumber']);
			$email = sanitize($_POST['email']);
			$password = sanitize($_POST['password']);
			$question_id = sanitize($_POST['securityQuestion']);
			$question_answer = sanitize($_POST['securityAnswer']);
			$isAdmin = (isset($_POST['isAdmin']) ? 1 : 0);

			//all fields submitted.
			if(!$databaseObj->userExists($userName)) {
				//user does NOT exist so add him.
				//echo $mobileNumber;

				$newUser = new User(
							null,
							$firstName, 
							$lastName,
							$userName, 
							$gender, 
							$mobileNumber, 
							$email,
							$password, 
							$question_id, 
							$question_answer,
							$isAdmin
							);
				$databaseObj::createUser($newUser);
				header("Location: " . "index.php");
			} else {
				//user allready exists
				$errors[1] = "Error: Username allready exists";
			}
		} else {
			$errors[0] = "Error: Some fields missing. (All Required)";
		}
	} 
?>


<div class="container">
 <div class="main" >
  
  <div class="row">
  	<div class="col-md-6 col-md-offset-3">
			<h1>Register</h1>
					<?php
		       	if(isset($errors)) {
		       		foreach($errors as $error) {
		       			echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
		       		}
		       	}
		       ?>
     <form method="post" action="register.php">
			<div class="form-group">
				<label>First Name:</label>
				<input type="text" class="form-control" name="firstName" placeholder="Enter First Name">
			</div>
			<div class="form-group">
				<label>Last Name:</label>
				<input type="text" class="form-control" name="lastName" placeholder="Enter Last Name">
			</div>
			<div class="form-group">
				<label>User Name:</label>
				<input type="text" class="form-control" name="userName" placeholder="Enter User Name">
			</div>
			<div class="form-group">
				<label>Gender:</label>
				<label class="radio-inline">
					<input type="radio"  name="gender" value="1"> Male
				</label>
				<label class="radio-inline">
					<input type="radio" name="gender" value="0"> Female
				</label>
			</div>
			<div class="form-group">
				<label>Phone Number:</label>
				<input type="text" class="form-control" name="phoneNumber" placeholder="Enter Phone Number">
			</div>
			 <div class="form-group">
				<label for="email">Email address</label>
				<input type="email" class="form-control" name="email" placeholder="Enter Your Email">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" name="password" placeholder="Enter Your Desired Password">
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="isAdmin"value="true">
					Admin?
				</label>
			</div>
			<div class="form-group">
				<label for="securityQuestion">Security Question:</label>
				<select class="form-control" name="securityQuestion">
					<?php
						$counter = 1;
						foreach($questions as $question) {
								echo "<option value=\"".$counter."\">".$question."</option>";
								$counter++;
						}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for="securityAnswer">Security Answer</label>
				<input type="text" class="form-control" name="securityAnswer" placeholder="Enter Your Security Answer">
			</div>
 			<button type="submit" class="btn btn-primary">Submit</button>
			</form>
		</div>
	</div>
 </div>
</div>
<?php
	require "footer.php";
?>
