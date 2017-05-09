<?php
	include("meetupConfig.php");
	session_start();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Meetup - Groups by interest</title>
</head>
<body>
	<?php include("header.php"); ?>
	<?php
		// Check if we were given an interest to display.
		if (isset($_GET['interest']) && $_GET['interest'] != '') {
			$interest = $_GET['interest'];
			echo "<h2>Groups interested in $interest</h2>";
			
			$stat = $db->prepare('SELECT groups.group_name as gname FROM about inner join groups 
			                      ON about.group_id = groups.group_id
			                      WHERE about.interest_name = ?');
			
			$stat->bind_param('s', $interest);
			$stat->execute();
			$result = $stat->get_result();
			
			if (mysqli_num_rows($result) > 0) {
				echo '<ul>';
				while ($row = $result->fetch_assoc()) {
					echo '<li>' . $row['gname'] . '</li>';
				}
				echo '</ul>';
			}
			
			else {
				echo 'No groups with that interest.';
			}
			
			$stat->close();
			$result->free();
		}
	?>
	<h2>Explore interests</h2>
	<ul>
	<?php
		// List all available interests.
		$statement = $db->prepare('SELECT interest_name FROM interest');
		$statement->execute();
		$result = $statement->get_result();
		while ($row = $result->fetch_assoc()) {
			$interest = $row['interest_name'];
			echo "<li><a href=\"?interest=$interest\">$interest</a></li>";
		}
		$result->free();
		$statement->close();
		
		$db->close();
	?>
	</ul>
</body>
</html>
