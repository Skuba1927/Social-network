		
		<div id="header">
			<div id="userName">
				Login: <?php echo $_SESSION['login'];?>
			</div>
			My social network
		</div>
		<div id="menu"> 
			<ul>
				<li><a href="page.php?id=<?=$_SESSION['id']?>">My page</a></li>
				<li><a href="friends.php">My friends</a></li>
				<li><a href="friends_requests.php">Friend requests
					<span class="count_requests">
						<?php 
						include_once "php/function.php";
						$count_requests = number_of_applications($_SESSION['id']);
						if ($count_requests > 0) {
							echo '('.$count_requests.')';
						}
						?>
					</span></a></li>
				<li><a href="message.php">My messages</a></li>
				<li><a href="news.php">News</a></li>
				<li><a href="edit_info.php">Edit information</a></li>
				<li><a href="edit_master.php">Edit master data</a></li>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>