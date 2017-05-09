<h1>Meetup</h1>
<?php
	if (isset($_SESSION['login_user'])) {
		
		echo '<p>Welcome, ' . $_SESSION['login_user'] . '. <a href="logout.php">Log out</a></p>';
	}
	else {
		echo '<p><a href="login.php">Log in or register</a></p>';
	}
?>
<p><a href="">Home</a></p>
