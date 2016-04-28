			<div class="rightContent">
				<h2>Users</h2>
				<p>Users registered</p>
				
				<?php

				$file = new files("users");
				$userlist = "";	
				if ($file->exists()) {
					$userlist = $file->readFile();
				} else{
					print_r("ERROR");
				}
				$i = 1;
				
				echo '<div class="user-list">';

				foreach($userlist as $user) {
					echo '<div class="profile-thumb">
									<a href="profile.php?user=' . $i . '">
										<img src="assets/img/profile' . $i++ . '.jpg" alt="profile"/>
										<span>' . $user[1] . '</span>
									</a>
							</div>';
							
							//if ($i == 3) break; // Just 2 profiles per page
				}

				echo '</div>';

				?>			
			</div>