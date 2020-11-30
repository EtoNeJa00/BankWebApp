<?php
	require_once "config.php";
	
	$connection = mysqli_connect(
	$config['db']['server'],
	$config['db']['username'],
	$config['db']['password'],
	$config['db']['name']
	);
	
	if($connection==false)
	{
		echo"не удалось подключиться к бд <br>";
		echo mysql_connect_error();
		exit();
	}
	function getUser()
	{
		$User;
		global $connection;
		$query = "SELECT * FROM user WHERE UserId='".$_SESSION['logged_user']['UserId']."'";
				if ($result = $connection->query($query)){
					$User = $result->fetch_assoc();
				}
				else 
				{
					return false;
				}
		return $User;
	}

	
?>