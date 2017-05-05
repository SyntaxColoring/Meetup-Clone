<?php
	include("meetupConfig.php");
	
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$userN = $_SESSION['login_user'];
		$sqlSt = $db->prepare("SELECT events.title, events.start_time from events INNER JOIN attend
				ON events.event_id = attend.event_id
				WHERE attend.rsvp = 1 AND attend.username = ?
				AND events.start_time BETWEEN CURRENT_DATE AND ADDDATE(CURRENT_DATE, INTERVAL 3 DAY)
				ORDER BY start_time DESC");
		$sqlSt->bind_param('s', $userN);
		$sqlSt->execute();
		$result = $sqlSt->get_result();
		
		while($row = $result->fetch_assoc()){
		# This is the code for displaying the dates for events today and the next three days
		# Max can you add the code for outputting the events 
			echo "Title: " . $row['events.title'] . " When: " . $row['events.start_time'] "<br>";
		}
	}


?>