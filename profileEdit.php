<?php	
require "header.php";
if(!isset($_SESSION['loggedIn']) || !isset($_SESSION['question_answer'])) {
	header("Location: " . "index.php");
	die();
}

$userName = $_SESSION['userName'];
$user = $databaseObj->getUser($userName);
$imageData = $databaseObj->getUserImages($user);
if(isset($_POST['updateSubmit'])) {
			if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['gender']) &&
			isset($_POST['phoneNumber']) && isset($_POST['email'])) {
			$firstName = sanitize($_POST['firstName']);
			$lastName = sanitize($_POST['lastName']);
			$gender = sanitize($_POST['gender']);
			$mobileNumber = sanitize($_POST['phoneNumber']);
			$email = sanitize($_POST['email']);
			if(isset($_POST['profilePicture'])) {
				$profilePicture = sanitize($_POST['profilePicture']);
				//echo "$profilePicture:". $profilePicture;
			} else {
				$profilePicture = null;
			}
			//all fields submitted.
			if($databaseObj->userExists($userName)) {
				//user does exist so update them.
				$return = $databaseObj->Update($firstName,$lastName,$gender,$mobileNumber, $profilePicture, $email, $userName);
				//need to relogin the user as his session information has been changed via the update
				$updatedUser = $databaseObj->getUser($userName);
				logUserIn($updatedUser);
				$success[0] = $return;
			} else {
				//user allready exists
				$errors[2] = "Error: Username does Not exist";
			}
		} else {
			$errors[3] = "Error: Not all fields filled in";
		}
}
?>
<div class="container">
  <div class="main" >
    <div class="row">
    	 <div class="col-md-12">
						<?php
							if(isset($errors)) {
							 		foreach($errors as $error) {
							 			echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
							 		}
							 	}
							if(isset($success)) {
							 		foreach($success as $accept) {
							 			echo "<div class=\"alert alert-success\" role=\"alert\">$accept</div>";
							 		}
							}
							if($imageData !== false) {
								echo "<div class=\"row\">";
								$count = 0;
								foreach($imageData as $image) {
									echo "<div class=\"col-md-2\" style=\"text-align:center;\">";
									echo "Image: ".$count;
						 			echo "<img src=\"$image\" style=\"max-width:100%;\"alt=\"".$_SESSION['userName']."'s Profile Image\" class=\"img-rounded\">";
									echo "</div>";
									$count++;
							 	}
								echo "</div>";
							}
						?>
					<h1>Edit <?php echo $_SESSION['userName']?>'s Profile</h1>
				<form method="post" action="profileEdit.php">
						<div class="form-group">
							<label>First Name:</label>
							<input type="text" class="form-control" name="firstName" value="<?php echo $_SESSION['firstName']?>">
						</div>
						<div class="form-group">
							<label>Last Name:</label>
							<input type="text" class="form-control" name="lastName" value="<?php echo $_SESSION['lastName']?>">
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
							<input type="text" class="form-control" name="phoneNumber" value="<?php echo $_SESSION['mobileNumber']?>">
						</div>
						 <div class="form-group">
							<label for="email">Email address</label>
							<input type="email" class="form-control" name="email" value="<?php echo $_SESSION['email']?>">
						</div>
								<?php
									if($imageData !== false) {
								?>
						<div class="form-group">
							<label for="email">Select Profile Picture</label>
							<select class="form-control" name="profilePicture">
								<?php
										$counter = 0;
										foreach($imageData as $image) {
												echo "<option value=\"".$image."\">Image: ".$counter.", ".$image."</option>";
												$counter++;
										}
									?>
							</select>
						</div>
						<?php
							}
						?>
 						<div class="form-group">
							<button type="submit" class="btn btn-primary" name="updateSubmit">Submit</button>
						</div>
					</form>
			</div>
		</div>
	</div>
</div>

