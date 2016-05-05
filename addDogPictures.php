<?php
$pageTitle = "Add_Pictures";
include 'control.php'; 
include 'top.php'; 
?>

<style>
</style>

</head>
<body id="<?php echo $pageTitle?>">

<?php include 'header.php'; ?>

    <div id="content">
        <?php
	/* Used mostly from lecture 20 from the CSU CS department courtesy Ross Beveridge*/
	
	$max_file_size = 4000000; // 1mb tops.
	$petID = SQLite3::escapeString(strip_tags($_GET['pet_id']));

	try {
		$dbh = new PDO("sqlite:doghouse.db");
	} catch(PDOException $e) {
		echo 'Connection failed. Error: ' . $e->getMessage();
	}

	if ($_FILES && isset ( $_FILES ["image"] )) {
		if ($_FILES ["image"] ["error"] == UPLOAD_ERR_OK) {  //if there is no error
			if ($_FILES ["image"] ["size"] > $max_file_size) {  //if the file is less than the max file size
				$error_msg = "File is too large.";
			        echo $error_msg;
			} else { //get the file type
				$ext = parseFileSuffix ( $_FILES ['image'] ['type'] );
				if ($ext == '') {
					$error_msg = "Unknown file type";
					echo $error_msg;
				} else { 

					//pet name will be name of dog and number of picture. Needs dog name and picture count.
					$sql = "SELECT name FROM Pets WHERE pet_id=$petID";
					$result = $dbh->query($sql)->fetch();
					$petName = $result['name'];

					$sql = "SELECT count(*) FROM PetPictures WHERE pet_id=$petID";
					$pictureNum = ($dbh->query($sql)->fetchColumn()) + 1;

					$filename = $petName . $pictureNum  . "." . $ext;
					
					//insert into database
					$sql = "INSERT INTO PetPictures (pictureName, pet_id) VALUES ('$filename',$petID)";
					$stmt = $dbh->prepare($sql);
					$stmt->execute();

					move_uploaded_file ( $_FILES ["image"] ["tmp_name"], "./images/". $filename);
                    chmod("./images/" . $filename,0755);
				}
			}
		} else if ($_FILES ["image"] ["error"] == UPLOAD_ERR_INI_SIZE || $_FILES ["image"] ["error"] == UPLOAD_ERR_FORM_SIZE) {
			$error_msg = "File is too large.";
		} else {
			$error_msg = "An error occured. Please try again. <!-- " . $_FILES ["image"] ["error"] . " -->";
		}
	}	
	?>

        <h3>Add a Picture</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="setPicture">
	    <input type="file" name="image" id="image" />
            <input type="submit" value="Submit">
        </form>

	<h3>Pictures Uploaded</h3>
	<?php
	    $pictures = "SELECT *  FROM PetPictures WHERE pet_id='$petID'";
	    foreach ($dbh->query($pictures) as $row){
		echo "<image src='images/" . $row['pictureName'] . "'>";
	    }
	?>
    </div>
<?php
/* Used from lecture 20. CSU CS department courtesy Ross Beveridge*/
function parseFileSuffix($iType) {
	if ($iType == 'image/jpeg') {
		return 'jpg';
	}
	if ($iType == 'image/gif') {
		return 'gif';
	}
	if ($iType == 'image/png') {
		return 'png';
	}
	if ($iType == 'image/tif') {
		return 'tif';
	}
	return '';
}

?>
<?php include 'footer.php'; ?>
