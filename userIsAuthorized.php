<?php
	// Returns whether a user is an authorized member of a group.
	function userIsAuthorized($db, $useri, $groupi) {
		$sqlStug = $db->prepare("SELECT authorized from belongs_to where username = ? AND group_id = ?");
		$sqlStug->bind_param('si', $useri, $groupi);
		$sqlStug->execute();
		$result = $sqlStug->get_result();
		
		if ($result->num_rows == 0) {
			// Not only is the user not an authorized member; he doesn't even
			// belong to the group.
			return false;
		}
		else {
			$rowug = $result->fetch_assoc();
			return $rowug['authorized'] != 0;
		}
	}
?>
