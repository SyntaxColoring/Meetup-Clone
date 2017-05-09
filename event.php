<?php
	include("meetupConfig.php");
	session_start();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Meetup - View event</title>
</head>
<body>
	<?php include("header.php"); ?>
	<?php
		$id = $_GET['id'];
		$statement = $db->prepare('SELECT * FROM events WHERE event_id = ?');
		$statement->bind_param('s', $id);
		$statement->execute();
		$result = $statement->get_result();
		
		$row = $result->fetch_assoc();
		if ($result->num_rows > 0) {
			echo '<h2>Event: '.$row['title'].'</h2>';
			echo '<p>Description: '.$row['description'].'</p>';
			echo '<p>When: '.$row['start_time'].' to '.$row['end_time'].'</p>';
			echo '<p>Where: '.$row['lname'].'</p>';
			
			if (isset($_SESSION['login_user'])) {
				echo '<form action="rsvp.php" method="post">';
				echo '<div><label>Going <input type="radio" name="rsvp" value="1"></label></div>';
				echo '<div><label>Not going <input type="radio" name="rsvp" value="0"></label></div>';
				echo '<input type="hidden" name="event_id" value="'.$id.'">';
				echo '<input type="submit" value="RSVP">';
				echo '</form>';
				if (isset($_SESSION['rsvp_message'])) {
					echo '<p>'.$_SESSION['rsvp_message'].'</p>';
					unset($_SESSION['rsvp_message']);
				}
			}
			else {
				echo '<p>Log in to RSVP.</p>';
			}
		}
		else {
			echo '<p>Error: There\'s no event with that ID.</p>';
		}
		$result->free();
		$statement->close();
		$db->close();
	?>
</body>
</html>
