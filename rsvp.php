<?php
#rsvp php code
#Peter Smondyrev, ps2816
#Redwanul Mutee, rm4243
#Max Marrone, mpm507
include("meetupConfig.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$eID = $_POST['event_id'];
	$postVal = $_POST['rsvp'];
	$userN = $_SESSION['login_user'];
	
	$sqlStat = $db->prepare("SELECT event_id, rsvp from attend where username = ? AND event_id = ?");
	$sqlStat->bind_param('ii', $userN, $eID);
	$sqlStat->execute();
	$result = $sqlStat->get_result();
	
	$countRow = mysqli_num_rows($result);
	
	// If the user has RSVPd to this event in the past, we need to update that
	// record instead of inserting a new one.
	if($countRow > 0){
		$sqlStat->close();
		$sqlStat = $db->prepare("UPDATE attend SET rsvp = ? where username = ?  AND event_id = ?");
		$sqlStat->bind_param('isi', $postVal, $userN, $eID);
		$sqlStat->execute();
		$sqlStat->close();
		$db->close();
		$_SESSION['rsvp_message'] = "RSVP updated.";
	}
	
	else {
		$rating = 0;
		$sqlStat->close();
		$sqlStat = $db->prepare("INSERT INTO attend(event_id, username, rsvp, rating) values(?, ?, ?, ?)");
		$sqlStat->bind_param('isii', $eID, $userN, $postVal, $rating);
		$sqlStat->execute();
		$sqlStat->close();
		$db->close();
		$_SESSION['rsvp_message'] = "RSVPd!";
	}
	
	header("Location: /event.php?id=$eID");
	exit;
}
?>
