<?php
#rsvp php code
include("meetupConfig.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$eventN = $_POST['eventName'];


	$eID = $row['event_id'];
	$postVal = $_POST['rsvp'];
	$userN = $_SESSION['login_user'];
	
	$sqlStat = $db->prepare("SELECT event_id, rsvp from attend where username = ?";
	$sqlStat->bind_param('ii', $eID, $postVal);
	$sqlStat->execute();
	$result = $sqlStat->get_result();
	
	$countRow = mysqli_num_rows($result)
	
	if($countRow > 0){
		if($result['authorized'] == 1){
			$sqlStat->close();
			$db->close;
			header("Location: ");
				
			exit;
			
		else{
			$sqlStat->close();
			$sqlStat = $db->prepare("UPDATE attend SET rsvp = 1 where username = ?  AND event_id = ?");
			$sqlStat->bind_param('si', $userN, $eID);
			$sqlStat->execute();
			$sqlStat->close();
			$db->close();
			header("Location: ");
			exit;
		}
		
	}
	
	if(mysql_num_rows($result) == 0){
		$sqlStat->close();
		$sqlStat = $db->prepare("INSERT INTO attend(event_id, username, rsvp) values(?, ?, ?)");
		$sqlStat->bind_param('isi', $eID, $userN, $postVal);
		$sqlStat->close();
		$db->close();
		header("Location: ");
		exit;
	}
	
	
}



?>