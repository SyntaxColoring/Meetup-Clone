<?php
	include("meetupConfig.php");
	session_start();
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Meetup - User home</title>
	</head>
	<body>
		<?php include('header.php'); ?>
		<h2>Your groups</h2>
		<ul>
		<?php
			$stmt = $db->prepare("SELECT groups.group_name AS gname, groups.group_id AS gid FROM groups INNER JOIN belongs_to
			                      ON groups.group_id = belongs_to.group_id 
			                      WHERE belongs_to.username = ?");
			$userN = $_SESSION['login_user'];
			$stmt->bind_param('s', $userN);
			$stmt->execute();
			
			$result = $stmt->get_result();
			
			$stmt->close();
			
			while($row = $result->fetch_assoc()){
				echo '<li><a href="group.php?id='.$row['gid'].'">'.$row['gname'].'</a></li>';
			}
		?>

		</ul>
		<h2>Your upcoming events</h2>
		<ul>
		<?php
			$userN = $_SESSION['login_user'];
			$sqlSt = $db->prepare("SELECT events.title AS etitle, events.start_time AS estart, events.event_id AS eid from events INNER JOIN attend
					ON events.event_id = attend.event_id
					WHERE attend.rsvp = 1 AND attend.username = ?
					AND events.start_time BETWEEN CURRENT_DATE AND ADDDATE(CURRENT_DATE, INTERVAL 3 DAY)
					ORDER BY start_time DESC");
			$sqlSt->bind_param('s', $userN);
			$sqlSt->execute();
			$result = $sqlSt->get_result();
			
			while($row = $result->fetch_assoc()){
				echo '<li><a href="event.php?id='.$row['eid'] . '">' . $row['etitle'] . '</a> (' . $row['estart'] . ')</li>';
			}
		?>
		</ul>
	</body>
</html>
