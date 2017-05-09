<?php
	include("meetupConfig.php");
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
			}
			
			else {
				echo '<p>Error: Group not found.</p>';
			}
		?>
	</body>
</html>
