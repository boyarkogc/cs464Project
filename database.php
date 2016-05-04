<?php 

function createTablePerson($dbh){
    $sql = "CREATE TABLE Person (
				 person_id INTEGER PRIMARY KEY,
				 firstName TEXT NOT NULL,
				 middleName TEXT,
				 lastName TEXT NOT NULL,
				 email TEXT UNIQUE NOT NULL,
				 username TEXT UNIQUE NOT NULL,
				 password TEXT NOT NULL,
				 priorDog BOOL NOT NULL,
				 priorCat BOOL NOT NULL,
				 priorTurtle BOOL NOT NULL,
				 havePet TEXT NOT NULL,
				 havePetExplain TEXT NOT NULL)";

    $status = $dbh->exec ($sql);
    if ($status === FALSE) {
	print_r ($dbh->errorInfo());
    }
}

function createTablePets($dbh){
    $sql = "CREATE TABLE Pets (
			       pet_id INTEGER PRIMARY KEY ASC,
			       name TEXT NOT NULL,
			       weight INTEGER NOT NULL,
			       age INTEGER NOT NULL,
			       neutered BOOL NOT NULL,
			       shortText TEXT NOT NULL,
			       longText TEXT NOT NULL)";

    $status = $dbh->exec ($sql);
    if ($status === FALSE) {
	print_r ($dbh->errorInfo());
    }
}

function createTablePetsPictures($dbh){
    $sql = "CREATE TABLE PetPictures (
				       picture_id INTEGER PRIMARY KEY ASC,
				       pictureName TEXT NOT NULL,
				       pet_id INTEGER NOT NULL,
				       FOREIGN KEY (pet_id) REFERENCES Pets(pet_id))";
    $status = $dbh->exec ($sql);
    if ($status === FALSE) {
	print_r ($dbh->errorInfo());
    }
}


function createDatabase(){
    try {
	$dbh = new PDO("sqlite:doghouse.db");
	createTablePerson($dbh);
	createTablePets($dbh);
	createTablePetsPictures($dbh);
    } catch(PDOException $e) {
	echo 'Connection failed. Error: ' . $e->getMessage();
    }
    
}

?>
