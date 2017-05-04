<?php
	define('dbserv', 'localhost:3306');
	define('dbuser', 'root');
	define('dbpass', 'root');
    define('dabname', 'meetup2.0');
	$db = new mysqli(dbserv,dbuser,dbpass,dabname);
	

?>
