<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/db.php";
	
	$user;
	if ( isset ($_SESSION['logged_user'])){
		$user = getUser();
		if($data['count']>$user["Money"])
		{
			echo 'Недостаточно средств';
			exit;
		}
	}else{
		echo 'Войдите';
		exit;
	}
	
	$userId = $_SESSION['logged_user']['UserId'];
	
	$data = $_POST;
	
	$query ="INSERT INTO lot (Amount,Percent,duration,CreditorId) 
	VALUES ('".$data['count']."','".$data['percent']."','".$data['days']."','".$userId."')";
	$sql=mysqli_query($connection, $query);
	    if ($sql) {
			
		$query = "UPDATE user
			SET Money = Money-".$data['count']."
			WHERE UserId = ".$user["UserId"];
		
		$connection->query($query);
			
			echo 'Лот добавлен';
		} else {
			echo '<p>Произошла ошибка: ' . mysqli_error($connection) . '</p>';
		}

	
	
?>