<?php
require_once 'database.php'; 
$salt = "ct310";

$questions = array("What is your favorite color?","What is your maiden name?","What is your hometown?","Who is your best friend?");


$databaseObj = new database();


function isLoggedIn() {
	if(isset($_SESSION["loggedIn"])) {
		if($_SESSION["loggedIn"] === true) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
function logUserIn($user) {
	$_SESSION["loggedIn"] = true;//passed first authentication
	$_SESSION['firstName'] = $user->firstName;
	$_SESSION['userName'] = $user->userName;
	$_SESSION['PID'] = $user->PID;
	$_SESSION['lastName'] = $user->lastName;			
	$_SESSION['gender'] = $user->gender;	
	$_SESSION['mobileNumber'] = $user->mobileNumber;	
	$_SESSION['is_admin'] = $user->is_admin;	
	$_SESSION['email'] = $user->email;
	$_SESSION['question_id'] = $user->question_id;
	$databaseObj = new database();
	$databaseObj->setOnlineTrue($_SESSION['userName']);
	//echo $user->question_answer;
}
function getUserFromSession() {
	if(!isset($_SESSION["loggedIn"])) {
		return false;
	}
	return new User($_SESSION['PID'], $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['userName'], $_SESSION['gender'], $_SESSION['mobileNumber'], $_SESSION['email'], null, $_SESSION['question_id'], $_SESSION['question_answer'], $_SESSION['is_admin'] );
	
}
function printSessionInfo() {
	echo "Printing Session Info <br>";
	echo "loggedIn: ".$_SESSION["loggedIn"]."<br>";
	echo "firstName: ".$_SESSION['firstName']."<br>";
	echo "userName: ".$_SESSION['userName']."<br>";
	echo "PID: ".$_SESSION['PID']."<br>";
	echo "lastName: ".$_SESSION['lastName']."<br>";		
	echo "gender: ".$_SESSION['gender']."<br>";
	echo "mobileNumber: ".$_SESSION['mobileNumber']."<br>";
	echo "is_admin: ".$_SESSION['is_admin']."<br>";
	echo "question_id: ".$_SESSION['question_id']."<br>";
	echo "email: ".$_SESSION['email']."<br>";
	if(isset($_SESSION['question_answer'])) {
		echo "question_answer: ".$_SESSION['question_answer']."<br>";
	} else {
		echo "question answer not set (need to verify)<br>";
	}
}
function createNewuser($firstName, $lastName, $userName, $gender, $mobileNumber, $imageLocation, $email, $password, $question_id, $question_answer, $is_admin) {
	$newUser = new User($firstName, $lastName, $userName, $gender, $mobileNumber, $imageLocation, $email, $password, $question_id, $question_answer, $is_admin);

}
function cleantext($input) {
 
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
 
    $output = preg_replace($search, '', $input);
    return $output;
}
// Sanitization function
function sanitize($input) {
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = sanitize($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
        $input  = cleantext($input);
        $output = trim($input);
    }
    return $output;
}
?>
