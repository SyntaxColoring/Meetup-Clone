<?php
	include("meetupConfig.php");
	include('userIsAuthorized.php');
	session_start();
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Meetup - View group</title>
	</head>
	<body>
		<?php
			include('header.php');
			
			$gid = $_GET['id'];
			
			$statement = $db->prepare('SELECT * FROM groups WHERE group_id = ?');
			$statement->bind_param('i', $gid);
			$statement->execute();
			$result = $statement->get_result();
			
			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				echo '<h2>Group: ' . $row['group_name'] . '</h2>';
				echo '<p>' . $row['description'] . '</p>';
				
				echo '<h2>This group\'s events</h2>';
				$eventStatement = $db->prepare("SELECT * FROM events WHERE group_id = ? ORDER BY start_time DESC");
				$eventStatement->bind_param('i', $gid);
				$eventStatement->execute();
				$eventResult = $eventStatement->get_result();
				
				echo '<ul>';
				while ($eventRow = $eventResult->fetch_assoc()) {
					$id = $eventRow['event_id'];
					$title = $eventRow['title'];
					$start_time = $eventRow['start_time'];
					echo "<li><a href=\"event.php?id=$id\">$title</a> ($start_time)</li>";
				}
				
				
				// Display the event creation form only if the user is an
				// authorized member.
				if (isset($_SESSION['login_user']) && userIsAuthorized($db, $_SESSION['login_user'], $gid)) {
					echo '<h2>Create an event for this group</h2>';
					echo '<form action="create-event.php" method="post">';
						echo '<div><label>Event title <input type="text" name="title"></label></div>'; 
						echo '<div><label>Description <input type="text" name="description"></label></div>';
						echo '<div><label>Start time <input type="date" name="start-time"></label></div>';
						echo '<div><label>End time <input type="date" name="end-time"></label></div>';
						echo '<div><label>Location <input type="text" name="lname"></label></div>';
						echo '<div><label>Location description <input type="text" name="ldesc"></label></div>';
						echo '<div><label>ZIP code <input type="text" name="zipcode"></label></div>';
						echo '<div><label>Latitude <input type="text" name="longitude"></label></div>';
						echo '<div><label>Longitude <input type="text" name="latitude"></label></div>';
						echo '<input type="hidden" name="group-choice" value="'.$gid.'">';
						echo '<input type="submit" value="Create event">';
					echo '</form>';
				}
			}
			
			else {
				echo '<p>Error: Group not found.</p>';
			}
		?>
	</body>
</html>
