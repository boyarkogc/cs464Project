<?php	
require "header.php";
	//printSessionInfo();
		$user;
  	if(isset($_GET['userName'])) {
			$userName = sanitize($_GET['userName']);
			if($databaseObj->userExists($userName )) {
				$userExists = true;
				$user = $databaseObj->getUser($userName);
				$imageData = $databaseObj->getUserImages($user);
				if(isset($_SESSION['userName'])) {
					if($userName == $_SESSION['userName'] && isset($_SESSION['question_answer'])) {//currently logged in user is on his/her profile
						$canEdit = true;
					} else {
						$canEdit = false;
					}
				} else {
					$canEdit = false;
				}
			} else {
				$userExists = false;
				$errors[1] = "Error: User does not exist.";
			}
		} else {
			$userExists = false;
			$errors[0] = "Error: No User specified.";
		}
		if(isset($_POST['updateSubmit'])) {
			if(isset($_POST['firstName']) && isset($_POST['lastName']) && isset($_POST['gender']) &&
			isset($_POST['phoneNumber']) && isset($_POST['email'])) {
			$firstName = sanitize($_POST['firstName']);
			$lastName = sanitize($_POST['lastName']);
			$gender = sanitize($_POST['gender']);
			$mobileNumber = sanitize($_POST['phoneNumber']);
			$email = sanitize($_POST['email']);

			//all fields submitted.
			if($databaseObj->userExists($userName)) {
				//user does exist so update them.
				$return = $databaseObj->Update($firstName,$lastName,$gender,$mobileNumber, null,$email, $userName);
				//need to relogin the user as his session information has been changed via the update
				$updatedUser = $databaseObj->getUser($username);
				
				$success[0] = $return;
			} else {
				//user allready exists
				$errors[2] = "Error: Username does Not exist";
			}
		} else {
			$errors[3] = "Error: Not all fields filled in";
		}
	}
	if(isset($_POST['sendRequest'])){
		$To = $_POST['sendRequest'];
		if($databaseObj->sendFriendRequest($userName, $To)){
			$success[0] = "Friend request sent! =)";
		}else{
			$errors[4] = 'You are already friends with '.$To;
		}
	}
	if(isset($_POST['AcceptRequest'])){
		$To = $_POST['AcceptRequest'];
		if($databaseObj->addFriend($userName, $To)){
			$success[0] = "=] You are now Friends! May your lives be sewn together with golden threads of joy! [=";
		}else{
			$errors[5] = "Friend addition failed";
		}
	}
	if(isset($_POST['DenyRequest'])){
		$To = $_POST['DenyRequest'];
		if($databaseObj->deleteRequest($userName, $To)){
			$success[0] = "The request has been deleted";
		}else{
			$errors[6] = "Friend request deletion failed";
		}
	}
		

    ?>

<div class="container">
  <div class="main" >
		<?php
			if(isset($errors)) {
			 		foreach($errors as $error) {
			 			echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
			 		}
					if(!$userExists) {
							die();
					}
			 	}
			if(isset($success)) {
			 		foreach($success as $accept) {
			 			echo "<div class=\"alert alert-success\" role=\"alert\">$accept</div>";
			 		}
			}
		?>
    <div class="row">
    	 <div class="col-md-8">
				<?php 
					echo "<h1>".$userName."'s Profile</h1>";
					if($databaseObj->getUserProfileImage($userName) !== false) {
							echo "<div class=\"col-md-12\" style=\"text-align:center;\">";
				 			echo "<img src=\"".$databaseObj->getUserProfileImage($userName)."\" style=\"max-width:100%;\"alt=\"".$user->userName."'s Profile Image\" class=\"img-rounded\">";
							echo "</div>";
					} else {
							echo "<div class=\"col-md-12\" style=\"text-align:center;\">";
				 			echo "<img src=\"images/defaultprofile.jpg\" style=\"max-width:100%;\"alt=\"".$user->userName."'s Profile Image\" class=\"img-rounded\">";
							echo "</div>";
					}
					echo "<div class=\"row\">";
					echo "<h3>".$userName."'s Images</h3>";
					if($imageData !== false) {
						foreach($imageData as $image) {
							echo "<div class=\"col-md-3\">";
				 			echo "<img src=\"$image\" style=\"max-width:100%;\"alt=\"".$user->userName."'s Profile Image\" class=\"img-rounded\">";
							echo "</div>";
					 	}
					}	
					echo "</div>";	
					if($canEdit) {
						echo " <div class=\"col-md-12\" style=\"text-align:center;\">";
						echo "<a href=\"profileEdit.php\" class=\"btn btn-primary\" style=\"margin:5px;\">Edit Profile</a>";
						echo "<a href=\"userImageupload.php\" class=\"btn btn-primary\" style=\"margin:5px;\">Upload Images</a>";
						echo "</div>";
					}
					?>
				<div class="row">
		  	 <div class="col-md-12" style="text-align:center;">
					<dl>
						<dt>User Online:</dt>
						<dd><?php echo $databaseObj->isOnline($user->userName); ?></dd>
					</dl>
					<dl>
						<dt>User Name:</dt>
						<dd><?php echo $user->userName; ?></dd>
					</dl>
					<dl>
						<dt>First Name:</dt>
						<dd><?php echo $user->firstName; ?></dd>
					</dl>
					<?php
						if(isLoggedIn()) {
					?>
					<dl>
						<dt>Last Name:</dt>
						<dd><?php echo $user->lastName; ?></dd>
					</dl>
					<dl>
						<dt>Email:</dt>
						<dd><?php echo $user->email; ?></dd>
					</dl>
					<dl>
						<dt>Phone Number:</dt>
						<dd><?php echo $user->mobileNumber; ?></dd>
					</dl>
					<dl>
						<dt>Gender:</dt>
						<dd><?php echo ($user->gender ? "Male" : "Female"); ?></dd>
					</dl>
					<?php
						}
					?>
					</div>
				</div>
			</div>
				
			<div class="col-md-4">
				<div class="col-xs-12">
				<?php if($canEdit) { ?>
				<h3>Pending Request</h3>
				<?php 
					//gets and displays pending friend request
					$pending = $databaseObj->getPendingRequest($userName);
					if(empty($pending)){
						echo "You have no Pending Request";
					}else{
						foreach($pending as $notFriend){
							$otherUser = $databaseObj->getUserFromPID($notFriend[0]);
						echo '<div class="col-xs-6" id="nonFriends" style="text-align:center;"><a href="profile.php?userName='.$otherUser->userName.'">'.$otherUser->userName.'</a><br>';
							echo $otherUser->firstName . ' ' . $otherUser->lastName.'<br>';
							if(is_null($otherUser->imageLocation)) {
								if($imageData !== false) {
									echo '<img src="' . $imageData[0] . '" alt = "'. $otherUser->firstName . ' profile image">';
								} else {
									echo '<img src="images/defaultprofile.jpg" alt = "'. $otherUser->firstName . ' profile image" >';
								}
							} else {
								echo '<img src="' . $otherUser->imageLocation . '" alt = "'. $otherUser->firstName . ' profile image">';
							}
					
				?>
					<form method="post" action="profile.php?userName=<?php echo $userName; ?>">
						<button type="submit" class="btn btn-success" name = "AcceptRequest" value="<?php echo $otherUser->userName; ?>">Accept</button>
						<button type="submit" class="btn btn-danger" name = "DenyRequest" value="<?php echo $otherUser->userName; ?>">Deny</button>
					</form>
						</div>
					<?php
							}
						echo "</div>";
						}
					}
				?>
				<div class="col-xs-12">
				<h3>Friends</h3>
				<?php 
					//gets the list of friend and displays them with images
					$friends = $databaseObj->getFriends($userName);
					if(empty($friends)){
						echo 'You currently have no friends... ]=';
					}else{
						foreach($friends as $friend){
							$otherUser = $databaseObj->getUserFromPID($friend[0]);
							echo '<div class="col-xs-6" id="nonFriends" style="text-align:center;"><a href="profile.php?userName='.$otherUser->userName.'">'.$otherUser->userName.'</a><br>';
							echo $otherUser->firstName . ' ' . $otherUser->lastName.'<br>';
							$imageData = $databaseObj->getUserImages($otherUser);
							if(is_null($otherUser->imageLocation)) {
								if($imageData !== false) {
									echo '<img src="' . $imageData[0] . '" alt = "'. $otherUser->firstName . ' profile image"></div>';
								} else {
									echo '<img src="images/defaultprofile.jpg" alt = "'. $otherUser->firstName . ' profile image" ></div>';
								}
							} else {
								echo '<img src="' . $otherUser->imageLocation . '" alt = "'. $otherUser->firstName . ' profile image"></div>';
							}

						}
						
					}
				?>
				</div>
				<div class="col-xs-12">
				<h3>Other Users</h3>
				<?php 
					$nonFriends = $databaseObj->getNonFriends($userName);
					if(empty($nonFriends)){
						echo 'You are friends with everyone! Hooray! =)';
					}else{
						foreach($nonFriends as $notFriend){
							$otherUser = $databaseObj->getUserFromPID($notFriend[0]);
							echo '<div class="col-xs-6" id="nonFriends" style="text-align:center;"><a href="profile.php?userName='.$otherUser->userName.'">'.$otherUser->userName.'</a><br>';
							echo $otherUser->firstName . ' ' . $otherUser->lastName.'<br>';
							$imageData = $databaseObj->getUserImages($otherUser);
						if(is_null($otherUser->imageLocation)) {
							if($imageData !== false) {
								echo '<img src="' . $imageData[0] . '" alt = "'. $otherUser->firstName . ' profile image">';
							} else {
								echo '<img src="images/defaultprofile.jpg" alt = "'. $otherUser->firstName . ' profile image" >';
							}
						} else {
							echo '<img src="' . $otherUser->imageLocation . '" alt = "'. $otherUser->firstName . ' profile image">';
						}
						if($canEdit) {
						?> 
					
						<form method="post" action="profile.php?userName=<?php echo $userName; ?>" style="padding:5px;">
							<button type="submit" class="btn btn-info" name = "sendRequest" value="<?php echo $otherUser->userName; ?>" >Send Request</button>
						</form>
					
						<?php
							}
						echo "</div>";
						}
					}
				?>

				</div>
			</div>
		</div>
	</div>
</div>
    </body>

</html>
</div>
