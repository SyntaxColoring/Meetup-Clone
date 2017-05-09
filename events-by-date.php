<?php
	include("meetupConfig.php");
	session_start();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Meetup - Events by date</title>
</head>
<body>
	<?php include("header.php"); ?>
	<h2>Find events by date range</h2>
	<ul>
	<?php
		$from = $_GET['from'];
		$to = $_GET['to'];
		
		if (!$from) $from = date("Y-m-d H:i:s");
		if (!$to) $to = date("Y-m-d H:i:s");
		
		$statement = $db->prepare('SELECT * FROM events WHERE start_time BETWEEN ? AND ? ORDER BY start_time DESC');
		$statement->bind_param('ss', $from, $to);
		$statement->execute();
		$result = $statement->get_result();
		
		while($row = $result->fetch_assoc()) {
			$title = $row['title'];
			$start_time = $row['start_time'];
			echo "<li>$title ($start_time)</li>";
		}
		
		$result->free();
		$statement->close();
		$db->close();
	?>
	</ul>
	<form action="" method="get">
		<div>
			<label>From <input name="from" type="datetime-local"></label>
		</div>
		<div>
			<label>To <input name="to" type="datetime-local"></label>
		</div>
		<input type="submit" value="Search">
	</form>
</body>
</html>
