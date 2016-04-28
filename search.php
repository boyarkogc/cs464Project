<?php
	$title = "Search Users";
	$userName = isset($_GET['user']) ? $_GET['user'] : "";

	include("inc/header.php");
	include("lib/files.php");
?>
 			<div class="leftContent">
				<h2>Userlist</h2>				
				<hr/>

				<div id="search-list">
					<?php

					$file = new files("users");
					$userlist = "";	
					if ($file->exists()) {
						$userlist = $file->readFile();
					}else{
						print_r("ERROR");
					}
					$i = 1;
					foreach($userlist as $user){
						
						echo '<div class="profile-thumb">
										<a href="profile.php?user=' . $i . '">
											<img src="assets/img/profile' . $i++ . '.jpg" alt="profile"/>
											<span>' . $user[1] . '</span>
										</a>
								</div>';

					}

					?>
				</div>

				<!-- <div id="search-list">
					<div class="profile-thumb">
						<a href="user.php?user=leonardovolpatto">
							<img src="assets/img/profile5.jpg" alt="Profile 5's photo" />
							<span>Stephen Hizzle</span>
						</a>
					</div>	

					<div class="profile-thumb">

						<a href="user.php?user=leonardovolpatto">
							<img src="assets/img/profile4.jpg" alt="Profile 4's photo" />
							<span>B. Gizzle</span>
						</a>
					</div>
					
					<div class="profile-thumb">
						<a href="user.php">
							<img src="assets/img/profile3.jpg" alt="Profile 3's photo" />
							<span>Chuck Nizzle</span>
						</a>
					</div>	
					
					<div class="profile-thumb">
						<a href="user.php">
							<img src="assets/img/profile2.jpg" alt="Profile 2's photo" />
							<span>Stock Phizzle</span>
						</a>
					</div>	

					<div class="profile-thumb">
						<a href="user.php">
							<img src="assets/img/profile1.jpg" alt="Profile 1's photo" />
							<span>Name</span>
						</a>
					</div>	
				</div> -->

			</div>
			
			<div class="rightContent">
			
			</div>

<?php
	include("inc/footer.php");
?>