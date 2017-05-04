<?php
	include("meetupConfig.php");
	session_start();
	
	$user_check = $_SESSION['login_user'];
	
	$userstat = $db->prepare("SELECT username from member where username = ?");
	$userstat->bind_param('s', $user_check);
	$userstat->execute();
	$sqlres = $userstat->get_result();
	
	$login_session = $sqlres['username'];
	$userstat->close();
	
	if(!isset($login_session)){	
		header("Location: loginpage.php");
	}

?>