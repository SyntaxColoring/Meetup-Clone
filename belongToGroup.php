<?php
	#code to use on webpage in which groups the user belongs to are shown
	include("meetupConfig.php");
	session_start();
	
	$stmt = $db->prepare("SELECT groups.group_name AS gname FROM groups INNER JOIN belongs_to
						ON groups.group_id = belongs_to.groups_id 
						WHERE belongs_to.username");
	$userN = $_SESSION['login_user'];
	$stmt->bind_param('s', $userN);
	$stmt->execute();
	
	$result = $stmt->get_result();
	
	$stmt->close();
	
	while($row = $result->fetch_assoc()){
		# print the $row['gname'] which the user is affiliated with.
	
	}



?>
