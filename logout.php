<?php
	Session_start();
	if(Session_destroy()){
		header("location: loginpage.php");
	}

?>