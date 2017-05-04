<?php
	#Create Event php code.

	include("meetupConfig.php");
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
	
		$etitle = $_POST['title'];
		$edesc = $_POST['description'];
		$estart = $_POST['start-time'];
		$eend = $_POST['end-time'];
		$egrID = $_POST['group-choice'];
		$elname = $_POST['lname'];
		$ezip = $_POST['zipcode'];
		
		checkLocation($elname, $ezip);
		
		$stmt = $db->prepare("INSERT into events(title, description, start_time, end_time, group_id, lname, zip)
		VALUES(?, ?, ?, ?, ?, ?, ?)");
		
		$stmt->bind_param('ssssisi', $etitle, $edesc, $estart, $eend, $egrID, $elname, $ezip);
		$stmt->execute();
		$stmt->close();
		
		$db->close();
		
		header("Location: ");
	}



}

	function checkLocation($lname, $zippy){
		$lstmt = $db->prepare("SELECT lname, zip FROM location where lname = ? AND zip = ?");
		$lstmt->bind_param('si', $lname, $zippy);
		$lstmt->execute();
		
		$result = $lstmt->get_result();
		
		if(mysqli_num_rows($result) >= 1){
			$lstmt->close();
			return;
		}
		else{
			$lstmt->close();
			$lstmt = $db->prepare("INSERT INTO location(lname, zip) VALUES(?, ?)");
			$lstmt->bind_param('si', $lname, $zippy);
			$lstmt->execute();
			$lstmt->close();
			return;
		}
	
	}


	function authorizedUser($useri, $groupi){
		$sqlStug = $db->prepare("SELECT authorized from belongs_to where username = ? AND group_id = ?");
		$sqlStug->bind_param('si', $useri, $groupi);
		$sqlStug->execute;
		$sqlStug->bind_result($authUse);
		$result = $sqlStug->get_result();
		$rowug = $result->fetch_assoc();
				
		if($rowug['authorized'] == 0){
			$sqlStug->close();
			#give a not authorized warning and allow User to do a certain action
			
		}
		else{
			$sqlStug->close();
			#give authorization for instance a SESSION var in which it is given a value.
			#IT helps prevent unnecessary temparing of the system.
			
		}
		
		
	}
?>
