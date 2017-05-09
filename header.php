<h1>Meetup</h1>
<?php
	if (isset($_SESSION['login_user'])) {
		
		echo '<p>Welcome, ' . $_SESSION['login_user'] . '. <a href="logout.php">Log out</a></p>';
	}
	else {
		echo '<p><a href="login.php">Log in or register</a></p>';
	}
?>
<ul>
	<li><a href="/">Home</a></li>
	<li><a href="groups-by-interest.php">Find groups by interest</a></li>
</ul>

