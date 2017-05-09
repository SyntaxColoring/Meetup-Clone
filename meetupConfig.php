<?php
	define('dbserv', 'localhost:3306');
	define('dbuser', 'root');
	define('dbpass', 'root');
    define('dabname', 'meetup');
	$db = new mysqli(dbserv,dbuser,dbpass,dabname);
	

?>
