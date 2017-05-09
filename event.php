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
		
		echo '<h2>Event: '.$row['title'].'</h2>';
		echo '<p>Description: '.$row['description'].'</p>';
		echo '<p>When: '.$row['start_time'].' to '.$row['end_time'].'</p>';
		echo '<p>Where: '.$row['lname'].'</p>';
		$result->free();
		$statement->close();
		$db->close();
	?>
</body>
</html>
