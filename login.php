<?php
	include('meetupConfig.php');
	session_start();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ($_POST['form'] == 'login') {
			$user = $_POST['login-username'];
			$pass = md5($_POST['login-password']);
			// We count the number of matching user-pass pairs.  If there are none,
			// the given login credentials are invalid.  If there's exactly one,
			// they're correct.  (If there's more than one, something's gone wrong.)
			$statement = $db->prepare('SELECT COUNT(*) FROM member WHERE username = ? AND password = ?');
			$statement->bind_param('ss', $user, $pass);
			$statement->execute();
			$result = $statement->get_result();
			$count = $result->fetch_row()[0];
			$result->free();
			$statement->close();
			$db->close();
			if ($count == 1) {
				$_SESSION['login_user'] = $user;
				header('Location: /');
			}
			else {
				$login_error = 'Wrong username or password.';
			}
		}
		
		else if ($_POST['form'] == 'register') {
			$user = $_POST['register-username'];
			$first = $_POST['register-first-name'];
			$last = $_POST['register-last-name'];
			$zip = $_POST['register-zip'];
			$pass = $_POST['register-password'];
			$passConfirmation = $_POST['register-retype-password'];
			
			// Basic validation...
			if (strlen($user) < 5) {
				$register_error = 'That username is too short.';
			}
			else if (strlen($zip) != 5) {
				$register_error = 'Please enter a valid 5-digit ZIP code.';
			}
			else if ($pass != $passConfirmation) {
				$register_error = 'Those passwords don\'t match.  Try again.';
			}
			else if (strlen($pass) < 5){
				$register_error = 'That password is too short.';
			}
			
			else {
				// We need to query the DB to make sure the username
				// isn't taken already, even if it looks valid.
				
				$statement = $db->prepare('SELECT COUNT(*) FROM member WHERE username = ?');
				$statement->bind_param('s', $user);
				$statement->execute();
				$result = $statement->get_result();
				$count = $result->fetch_row()[0];
				$result->free();
				$statement->close();
				if ($count > 0) {
					$register_error = 'That username is already taken.';
				}
				else {
					// Now we actually create the user.
					$statement = $db->prepare('INSERT INTO member (username, password, firstname, lastname, zipcode) VALUES (?, ?, ?, ?, ?)');
					$statement->bind_param('sssss', $user, md5($pass), $first, $last, $zip);
					$statement->execute();
				}
				$db->close();
				
				header('Location: /');
			}
		}
	}
?><!DOCTYPE html>
<html>
<head>
	<title>Meetup - Login or register</title>
	<meta charset="utf-8">
</head>
<body>
<?php include('header.php'); ?>
	<h2>Login</h2>
	<form action="" method="post">
		<div><label>
			Username
			<input type="text" name="login-username">
		</label></div>
		<div><label>
			Password
			<input type="password" name="login-password">
		</label></div>
		<input type="hidden" name="form" value="login">
		<input type="submit" value="Log in">
	</form>
	<?php if (isset($login_error) && $login_error !== '') {
		echo "<p>Error: $login_error</p>";
	} ?>
	
	<h2>Register</h2>
	<form action="" method="post">
		<div><label>
			Username
			<input type="text" name="register-username">
		</label></div>
		<div><label>
			First name
			<input type="text" name="register-first-name">
		</label></div>
		<div><label>
			Last name
			<input type="text" name="register-last-name">
		</label></div>
		<div><label>
			ZIP code
			<input type="text" name="register-zip">
		</label></div>
		<div><label>
			Password
			<input type="password" name="register-password">
		</label></div>
		<div><label>
			Retype password
			<input type="password" name="register-retype-password">
		</label></div>
		<input type="hidden" name="form" value="register">
		<input type="submit" value="Register">
	</form>
	<?php if (isset($register_error) && $register_error !== '') {
		echo "<p>Error: $register_error</p>";
	} ?>
</body>
</html>
