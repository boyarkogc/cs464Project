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
    	<ul>
    		<li><a href="http://www.google.com">John Doe</a></li>
    		<li>Hillary Clinton</li>
    	</ul>
				
		</div>
	</div>
</div>
    </body>

</html>
</div>
