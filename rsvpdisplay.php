<?php
	#code for user to see which group they are in.
	include("meetupConfig.php");
	session_start();
	
	$stmt = $db->prepare("SELECT events.title FROM events INNER JOIN attend
						ON events.event_id = attend.event_id 
						WHERE attend.username = ?");
						
	$userN = $_SESSION['login_user'];
	$stmt->bind_param('s', $userN);
	$stmt->execute();
	
	$result = $stmt->get_result();
	$stmt->close();
	while($row = $result->fetch_assoc()){
		#$row['event.title']  I leave to formatting to you Max
	
	}

?>