<?php
#Create Event php code.
#Peter Smondyrev, ps2816
#Redwanul Mutee, rm4243
#Max Marrone, mpm507

include("meetupConfig.php");
include("userIsAuthorized.php");
session_start();

function checkLocation($db, $lname, $zippy, $description, $latitude, $longitude){
	$lstmt = $db->prepare("SELECT lname, zip FROM location where lname = ? AND zip = ?");
	$lstmt->bind_param('si', $lname, $zippy);
	$lstmt->execute();
	
	$result = $lstmt->get_result();
	
	if(mysqli_num_rows($result) >= 1){
		$lstmt->close();
		return;
	}
	else{
		error_log("Creating location.");
		$lstmt->close();
		$lstmt = $db->prepare("INSERT INTO location(lname, zip, description, latitude, longitude) VALUES(?, ?, ?, ?, ?)");
		$lstmt->bind_param('sisii', $lname, $zippy, $description, $latitude, $longitude);
		$lstmt->execute();
		$lstmt->close();
		return;
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$etitle = $_POST['title'];
	$edesc = $_POST['description'];
	$estart = $_POST['start-time'];
	$eend = $_POST['end-time'];
	$egrID = $_POST['group-choice'];
	$elname = $_POST['lname'];
	$eldesc = $_POST['ldesc'];
	$ezip = $_POST['zipcode'];
	$elat = $_POST['latitude'];
	$elon = $_POST['longitude'];
	
	
	if (userIsAuthorized($db, $_SESSION['login_user'], $egrID)) {
		checkLocation($db, $elname, $ezip, $eldesc, $elat, $elon);
		
		$stmt = $db->prepare("INSERT into events(title, description, start_time, end_time, group_id, lname, zip)
		VALUES(?, ?, ?, ?, ?, ?, ?)");
		
		$stmt->bind_param('ssssisi', $etitle, $edesc, $estart, $eend, $egrID, $elname, $ezip);
		$stmt->close();
		
		$db->close();
		
		$_SESSION["event_creation_message"] = "Event created!";
		header("Location: group.php?id=".$egrID);
	}
	
	else {
		error_log("Unauthorized user tried to create event!");
	}
}
?>
