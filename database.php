<?php
require_once 'users.php';
/*
 * I'm thinking this class will be used for all database operations Feel free to alter code 0 (false) and 1 (true) for boolean flags -Ryan S.
 */
class database extends PDO {
	public $salt = "ct310";
	// Grabs from database
	public function __construct() {
		//$this->createDatabase();
		parent::__construct ( "sqlite:./validUsers.db" );
	}
	
	/*
	 * Creates a database by dropping old tables and adding new ones This should only be called if a .dbo file does not exist
	 */
	public static function createDatabase() {
		// Connect to database
		global $dbh;
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		
		// Dropping old tables
		$sql = "DROP TABLE IF EXISTS User";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			print_r ( $dbh->errorInfo () );
		}
		
		$sql = "DROP TABLE IF EXISTS Question";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			print_r ( $dbh->errorInfo () );
		}
		
		$sql = "DROP TABLE IF EXISTS Friends";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			print_r ( $dbh->errorInfo () );
		}
		
		$sql = "DROP TABLE IF EXISTS Friend_Request";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			print_r ( $dbh->errorInfo () );
		}
		
		// Creating new tables
		$sql = "CREATE TABLE User (id INTEGER PRIMARY KEY, first_name varchar(50), last_name varchar(50),
						username varchar(50),  gender varchar(50), mobile_number varchar(13),
						immage_loc varchar(200), email varchar(55), password varchar(100),
						question_id INTEGER, question_answer varchar(50), is_admin INTEGER, online INTEGER);";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			echo "failed User";
			print_r ( $dbh->errorInfo () );
		} else {
			echo 'success: ' . $status;
			// die;
		}
		
		$sql = "CREATE TABLE Question (id INTEGER PRIMARY KEY, text varchar(150));";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			echo "failed question";
			print_r ( $dbh->errorInfo () );
			die ();
		}
		
		$sql = "CREATE TABLE Friends (UserID INTEGER, Friend INTEGER);";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			echo "failed Friends";
			print_r ( $dbh->errorInfo () );
			die ();
		}
		
		$sql = "CREATE TABLE Friend_Request (UserID INTEGER, Friend INTEGER);";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			echo "failed Friend_request";
			print_r ( $dbh->errorInfo () );
			die ();
		}
		$sql = "CREATE TABLE Images (UserID INTEGER, image_loc INTEGER);";
		$status = $dbh->exec ( $sql );
		if ($status === FALSE) {
			echo "failed Friend_request";
			print_r ( $dbh->errorInfo () );
			die ();
		}
		self::addUsers ();
		self::addQuestions ();
	}
	
	// Adds questions to the database
	public function addQuestions() {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$sql = "INSERT INTO Question (id, text) VALUES (0, 'What is your favorite color?');";
		$dbh->exec ( $sql );
		$sql = "INSERT INTO Question (id, text) VALUES (1, 'What is your maiden name?');";
		$dbh->exec ( $sql );
		$sql = "INSERT INTO Question (id, text) VALUES (2, 'What is your hometown?');";
		$dbh->exec ( $sql );
		$sql = "INSERT INTO Question (id, text) VALUES (3, 'Who is your best friend?');";
		$dbh->exec ( $sql );
	}
	
	// adds default users
	function addUsers() {//($PID, $firstName, $lastName, $userName, $gender, $mobileNumber, $email, $password, $question_id, $question_answer, $is_admin)
		$admin = new User ( null,"admin", "admin", "admin", 1, "3333333333", "Admin@Admin.com", "admin", 1, "red", 1 );
		self::createUser($admin);
		$user1 = new User ( null,"John", "Doe", "johnDoe", 1, "123-1234", "john@doe.com", "johnDoe", 2, "ron", 0 );
		self::createUser($user1);
		$user2 = new User ( null,"Jenny", "Smith", "jennySmith", 0, "00000000", "jenny@smith.com", "jennySmith", 3, "Fort Collins", 0 );
		self::createUser($user2);
		$user3 = new User ( null,"Ron", "Don", "ronDon", 1, "123-5232", "ron@Don.com", "ronDon", 4, "John", 0 );
		self::createUser($user3);
		$user4 = new User ( null,"Kate", "Date", "kateDate", 0, "123-1234", "kate@Date.com", "kateDate", 3, "Denver", 0);
		self::createUser($user4);
		$user5 = new User ( null,"Something", "Something", "somethingSomething", 1, "11111111", "something@something.com", "somethingSomething", 1, "blue", 0 );
		self::createUser($user5);
	}
	
	// Grabs all users from database
	function getUsers() {
		$sql = "SELECT * FROM user";
		$result = $this->query ( $sql );
		
		if ($result === FALSE) {
			echo '<pre class="bg-danger">';
			print_r ( $this->errorInfo () );
			echo '</pre>';
			return array ();
		}
		
		$users = array ();
		foreach ( $result as $row ) {
			$users [] = User::getUserFromRow ( $row );
		}
		if (empty ( $users )) {
			return false;
		}
		return $users;
	}
	//Gets user given the PID
	function getUserFromPID($pID){
		$users = $this->getUsers ();
		foreach ( $users as $user ) {
			if ($pID == $user->PID) {
				return $user;
			}
		}
		return null;
		
	}
	// finds user with same username and password
	function findUser($username, $password) {
		$salt = "ct310";
		
		$users = $this->getUsers ();
		foreach ( $users as $user ) {
			
			if ($username == $user->userName) {
				//print_r ( $user );
				if ($user->password == md5 ( $salt . $password )) {
					
					return $user;
				} else {
					return null;
				}
			}
		}
		return null;
	}
	function getUser($username) {
		$users = $this->getUsers ();
		foreach ( $users as $user ) {
			if ($username == $user->userName) {
					return $user;
			}
		}
		return null;
	}
	public function userExists($username) {
		$users = $this->getUsers ();
		if ($users === FALSE) {
			return false;
		}
		foreach ( $users as $user ) {
			if ($username == $user->userName) {
				return true;
			}
		}
		return false;
	}
	// returns false if no PID
	public function getPID($username) {
		$users = $this->getUsers ();
		if ($users === FALSE) {
			return false;
		}
		foreach ( $users as $user ) {
			if ($username == $user->userName) {
				return $user->PID;
			}
		}
		return false;
	}
	public static function createUser($user) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$sql_user = "INSERT INTO User (first_name, last_name, username, gender, mobile_number, email, password, question_id, question_answer, is_admin) VALUES (:first_name, :last_name, :userName, :gender,:mobile_number, :email, :password, :question_id, :question_answer, :is_admin)";
		$users_stm = $dbh->prepare ( $sql_user );
		if (! $users_stm->execute ( array (
				':first_name' => $user->firstName,
				':last_name' => $user->lastName,
				':userName' => $user->userName,
				':gender' => $user->gender,
				':mobile_number' => $user->mobileNumber,
				':email' => $user->email,
				':password' => $user->password, // already salted
				':question_id' => $user->question_id,
				':question_answer' => $user->question_answer,
				':is_admin' => $user->is_admin 
		) ))
			
			$dbh->exec ( $sql );
	}
	function findAnswer($answer) {
		$users = $this->getUsers ();
		
		foreach ( $users as $user ) {
			if ($_SESSION ["userName"] == $user->userName) {
				if ($user->question_answer == $answer) {
					return $user;
				} else {
					return null;
				}
			}
		}
		return null;
	}
	
	// Checks to make sure user is logged in
	function loginRequired() {
		global $_SESSION;
		global $config;
		
		if (isset ( $_SESSION ["userName"] ) && isset ( $_SESSION ["color"] )) {
			$users = $this->getUsers ();
			
			foreach ( $users as $u ) {
				
				if ($u->userName == $_SESSION ["userName"]) {
					
					return;
				}
			}
			header ( "Location: login.php" );
			exit ();
		}
		$_SESSION ['redirect'] = $_SERVER ["REQUEST_URI"];
		// If we got here then we need to log in
		header ( "Location: login.php" );
		exit ();
	}
	
	// Changes security question id
	function changeSecurity($qID) {
		try {
			$dbh = new PDO ( "sqlite:user.db" );
			echo '<pre class="bg-success">';
			echo 'Connection successful.';
			echo '</pre>';
		} catch ( PDOException $e ) {
			echo '<pre class="bg-danger">';
			echo 'Connection failed: ' . $e->getMessage ();
			echo '</pre>';
			die ();
		}
		
		$sql = "UPDATE user SET question_id=" . $qID . " WHERE id=" . $_SESSION ['PID'];
		$query = $dbh->exec ( $sql );
		
		if ($query === FALSE) {
			echo '<pre class="bg-danger">';
			print_r ( $dbh->errorInfo () );
			echo '</pre>';
			die ();
		} else {
			echo '<pre class="bg-success">';
			echo 'Number of rows effected: ' . $status;
			echo '</pre>';
		}
	}
	
	// changes security answer
	function changeAnswer($answer) {
		try {
			$dbh = new PDO ( "sqlite:user.db" );
			echo '<pre class="bg-success">';
			echo 'Connection successful.';
			echo '</pre>';
		} catch ( PDOException $e ) {
			echo '<pre class="bg-danger">';
			echo 'Connection failed: ' . $e->getMessage ();
			echo '</pre>';
			die ();
		}
		
		$sql = "UPDATE user SET question_answer='" . $answer . "' WHERE id=" . $_SESSION ["PID"];
		$query = $dbh->exec ( $sql );
		
		if ($query === FALSE) {
			echo '<pre class="bg-danger">';
			print_r ( $dbh->errorInfo () );
			echo '</pre>';
		} else {
			echo '<pre class="bg-success">';
			echo 'Number of rows effected: ' . $status;
			echo '</pre>';
		}
		return 1;
	}
	
/*
	 * Send a friend request returns an error or confirmation message
	 */
	public function sendFriendRequest($From, $To) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}

		$userA = self::getPID ( $From);
		$userB = self::getPID ( $To);
		
		$sql = "SELECT * FROM Friends WHERE UserID = '$userA' AND Friend = '$userB'";
		$result = $dbh->query ( $sql );
		$row = $result->fetchAll();
		// If they are already friends, deny request
		if (!empty($row)) {
			$msg = "You are already friends with" . $userA->userName . "!";
			return $msg;
		} 
		$sql = "SELECT * FROM Friend_Request WHERE UserID = '$userA' AND Friend = '$userB'";
		$result = $dbh->query ( $sql );
		$row = $result->fetchAll();
		if (!empty($row)) {
			return true;
		}else {
			$sql = "INSERT INTO Friend_Request (UserID, Friend)
				VALUES ('$userA','$userB')";
			$dbh->query ( $sql );
			//$msg = "Friend request sent! =)";
			return true;
		}
	}
	
/*
	 * Deletes a friend request Returns a deleted message
	 */
	public function deleteRequest($From, $To) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		
		$userA = self::getPID ( $From );
		$userB = self::getPID ( $To );
		
		// remove the pending friend request
		$sql = "DELETE FROM Friend_request WHERE UserID = '$userB' AND  Friend = '$userA'";
		$dbh->query ( $sql );
		
		$msg = "Friend request Deleted! =)";
		return true;
	}
	
	/*
	 * Add a friend returns a confirmation message
	 */
	public function addFriend($user1, $user2) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		
		$userA = self::getPID ( $user1 );
		$userB = self::getPID ( $user2 );
		
		// ADD friend relationship. It is binary so added twice
		$sql = "INSERT INTO Friends (UserID, Friend)
						VALUES ('$userA','$userB')";
		$dbh->query ( $sql );
		
		$sql = "INSERT INTO Friends (UserID, Friend)
						VALUES ('$userB','$userA')";
		$dbh->query ( $sql );
		
		// remove the pending friend request
		$sql = "DELETE FROM Friend_request WHERE UserID = '$userB' AND  Friend = '$userA'";
		$dbh->query ( $sql );
		$sql = "DELETE FROM Friend_request WHERE UserID = '$userA' AND  Friend = '$userB'";
		$dbh->query ( $sql );
		$msg = "Friend request accepted! =)";
		return true;
	}
	
	/*
	* Adds image location to the table Returns completion message
	*/
	public function addImage($user, $path) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
			$pID =  $this->getPID($user->userName);
			$sql = "INSERT INTO Images (UserID, image_loc) VALUES ('$pID','$path')";
			$dbh->query ( $sql );
			$msg = "Image uploaded successfully! =]";
			return $msg;
	}
		/*
	 * In order to update all the forum data for the user must be passed in...
	 * I think we can make into if its easier...
	 * first_name varchar(50), last_name varchar(50),
						username varchar(50),  gender varchar(50), mobile_number varchar(13),
						immage_loc varchar(200), email varchar(55), password varchar(100),
						question_id INTEGER, question_answer varchar(50), is_admin INTEGER);";
	 */
	public function Update($firstName, $lastName, $gender, $mobileNumber, $imageLocation, $email, $userName){
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$pID = $this->getPID($userName);
		$statement = $dbh->prepare("UPDATE User SET first_name = :firstName, last_name = :lastName,
				 gender = :gender, mobile_number = :mobile, immage_loc = :imageLocation, 
				 email = :email WHERE id = :pid");
		$statement->execute(array(':pid' => $pID , ':email' => $email, ':imageLocation' => $imageLocation, ':mobile' => $mobileNumber,':gender' => $gender, ':firstName' => $firstName, ':lastName' => $lastName));
		$msg = "Information updated successfully! 8-]";
		return $msg;
	}
	public function getUserImages($user) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$statement = $dbh->prepare("SELECT * FROM Images WHERE UserID= :pid");
		$statement->execute(array(':pid' => $user->PID));
		$row = $statement->fetchAll(); 
		for($j = 0; $j < count($row);$j++) {
			$imageData[$j] = $row[$j]['image_loc'];
		}
		if(isset($imageData)) {
			return $imageData;
		} else {
			return false;
		}
		
	}
	public function isOnline($userName) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$statement = $dbh->prepare("SELECT online FROM User WHERE username= :userName");
		$statement->execute(array(':userName' => $userName));
		$row = $statement->fetch(); 
		if($row['online'] == 1) {
			return "True";
		} else {
			return "False";
		}
		
	}
	public function setOnlineTrue($userName) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$statement = $dbh->prepare("UPDATE User SET online = 1 WHERE username= :userName");
		$statement->execute(array(':userName' => $userName));
	}
	public function setOnlineFalse($userName) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$statement = $dbh->prepare("UPDATE User SET online = 0 WHERE username= :userName");
		$statement->execute(array(':userName' => $userName));

		
	}
	public function getUserProfileImage($userName) {
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		$statement = $dbh->prepare("SELECT immage_loc FROM User WHERE username= :userName");
		$statement->execute(array(':userName' => $userName));
		$row = $statement->fetch(); 
		if(isset($row['immage_loc'])) {
			return $row['immage_loc'];
		} else {
			return false;
		}
	}
	/*
	 * Gets the users friends
	 */
	public function getFriends($userName){
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		
		$pID = $this->getPID($userName);
		$sql = "SELECT Friend From Friends WHERE UserID = '$pID';";
		$result = $dbh->query($sql);
		$friends=$result->fetchAll();
		
		return $friends;
	}
	
		/*
	 * Gets everyone that isn't a friend
	*/
	public function getNonFriends($userName){
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		//get list of friends
		$friends = self::getFriends($userName);
		
		//get all the users
		$pID = $this->getPID($userName);
		$sql = "SELECT id From User WHERE id != '$pID';";
		$result = $dbh->query($sql);
		$allUsers=$result->fetchAll();
		
		//remove friends from allUsers
		foreach ($friends as $x){
			//search the array for the value and store the index
			if(($index = array_search($x, $allUsers)) == true ){
				//if found remove the index
				unset($allUsers[$key]);
			}
		}
		return $allUsers;
	}
	
	/*
	 * Get pending friend request
	 */
	public function getPendingRequest($userName){
		try {
			$dbh = new PDO ( "sqlite:./validUsers.db" );
		} catch ( PDOException $e ) {
			echo 'CONNECTION FAILED: ' . $e->getMessage ();
			die ();
		}
		
		$pID = self::getPID($userName);
		
		$sql = "SELECT UserID FROM Friend_Request WHERE Friend = '$pID'";
		$result = $dbh->query($sql);
		$request = $result->fetchAll();
		
		return  $request;
	}

}


?>

