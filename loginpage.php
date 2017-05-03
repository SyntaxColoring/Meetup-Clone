<?php
	include("meetupConfig.php");
	session_start();
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		$userN =  $_POST['username'];
		$passN =  md5($_POST['password']);
		

		$sqlStmt = $db->prepare("SELECT username, password FROM member where username = ? AND password = ?");
		$sqlStmt->bind_param("ss", $userN, $passN);
		$sqlStmt->execute();
		
		$result = $sqlStmt->get_result();
		$count = mysqli_num_rows($result);
		$sqlStmt->close();
		$db->close();
		if($count == 1){
			$_SESSION['login_user'] = $userN;
			header("location: welcome.php");
		}
		else{
			$error = "Your Username or Password is not valid" . $count;
		}
	
	}

?>


<html>
<head>

<style>
div.center{
	margin:auto;
	width: 50%;
	text-align: center;
}

</style>


</head>


<body>

<div class = "center">
<form action = "" method = "post" accept-charset="UTF-8" >
	<label>Username: </label><input type = "text" name = "username" class = "box"/><br></br>
	<lable>Password: </label><input type = "password" name = "password" class = "box"/><br></br>
	<input type = "submit" value = "Submit"/><br></br>

</form>
</div>

<div style = "font-size:11px; color:#cc0000; margin-top:10px">
<?php 
echo $error; 


?>

</div>


</body>




</html>