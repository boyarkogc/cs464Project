<?php
	
	class User
	{
		public $PID;
		public $firstName;
		public $lastName;
		public $userName;
		public $gender;
		public $mobileNumber;
		public $imageLocation;
		public $email;
		public $password;
		public $question_id;
		public $question_answer;
		//added admin marker		
		public $is_admin;

		
		/*
	 	* Creates a new user.
	 	*/
		// public function __construct($firstName, $lastName, $userName, $gender, $mobileNumber, $imageLocation, $email, $password, $question_id, $question_answer, $is_admin) {
		// 	$saltValue = "ct310";
		// 	$this->firstName = $firstName;
		// 	$this->lastName = $lastName;
		// 	$this->userName = $userName;
		// 	$this->gender = $gender;
		// 	$this->mobileNumber = $mobileNumber;
		// 	$this->imageLocation = $imageLocation;
		// 	$this->email = $email;
		// 	//Hashing passsword with salt
		// 	$this->password =  md5($password, $saltValue);
		// 	$this->question_id = $question_id;
		// 	$this->question_answer = $question_answer;
		// 	//admin
		// 	$this->is_admin = $is_admin;
		// }

	public static function getUserFromRow($row){
		$user = new User();

		$user->PID = $row['id'];
		$user->userName = $row['username'];
		$user->firstName = $row['first_name'];
		$user->lastName = $row['last_name'];
		$user->password = $row['password'];
		$user->question_id = $row['question_id'];
		$user->color = $row['question_answer'];

		$user->is_admin = $row['is_admin'];
		$user->gender = $row['gender'];
		$user->mobileNumber = $row['mobile_number'];
		$user->imageLocation = $row['immage_loc'];
		$user->email = $row['email'];



		return $user;

	}
		/*
		 * Compares input user gave to stored information
		 */
		// public static function getUser($username, $password){
		// 	$dbh = new PDO("sqlite:./valid.db");
		// 	//get the user's row
		// 	$sql = "SELECT username, password FROM User WHERE username='" . $username . "';";
		// 	$result = $dbh->query($sql);
		// 	if($result === FALSE ) {
		// 		return null;
		// 	}
		// 	$array = $result->fetchObject();
		// 	//verify username and password
		// 	if($array->username == $username){
		// 		if($array->password == md5($password, $saltValue)){
		// 			return $array;
		// 		}
		// 	}
		// 	return null;
		// }
		
		
		// /*
		//  * Returns string if user gave correct answer Used for authentication
		//  */
		// public static function checkQuestion($ans){
		//     $dbh = new PDO("sqlite:./valid.db");
		    
		//     $name = $_SESSION['userName'];
		//     //get the user's row
		//     $sql = "SELECT question_answer FROM User WHERE username = '" . $name . "';";
		//     $result = $dbh->query($sql);
		//     if($result->fetchColumn() == $ans){
		//     	return $result;
		//     }
		//     return null;
		// }

		// //Verifies that the user is logged in. Must be at the top every page that displays html except the login page

		// public static function isLoggedIn(){
		// 	global $_SESSION;
		// 	$dbh = new PDO("sqlite:./valid.db");
			
		// 	if(isset($_SESSION['userName'])){
		// 		$sql = "SELECT username FROM User WHERE username='" . $_SESSION['userName'] . "';";
		// 		$result = $dbh->query($sql);
		// 		if($result->fetchColumn() == $_SESSION["userName"]){
		// 			return true;
		// 		}
		// 	}
		// 	$_SESSION['redirect'] = $_SERVER["REQUEST_URI"];
		// 	//REDIRECT TO LOGIN PAGE
		// 	header("Location: login.php");
		// 	exit();
		// }
		
		
		// /*
		//  * Get the question to be displayed for the user that is logging in. Used for authentication
		//  */
		// public static function getQuestion($user){
		// 	$dbh = new PDO("sqlite:./valid.db");
		// 	$sql = "SELECT text FROM User, Question WHERE User.username = '" . $user ."' AND Question.id = User.question_id";
		// 	$result = $dbh->query($sql);
		// 	$obj = $result->fetchObject();
		// 	return $obj->text;
		// }
	}	
?>
