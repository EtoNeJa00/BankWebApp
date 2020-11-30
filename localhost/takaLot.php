<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/config.php";
	require_once $_SERVER['DOCUMENT_ROOT']."/includes/db.php";
	
	//var_dump($_GET);
	if ( !isset ($_SESSION['logged_user']))
	{
		header('Location: /');	
		exit;
	}

	$userId = $_SESSION['logged_user']['UserId'];
	
	$query = "SELECT * FROM Lot WHERE LotId=".$_GET['id'];
	if ($result = $connection->query($query)){
		$Lot = $result->fetch_assoc();
		//var_dump($Lot);
		
		$query = "INSERT INTO takenlot (
			Amount,
			Percent,
			Duration,
			CreditorId,
			DebtorId,
			TakeDate
		) VALUES (
			'".$Lot['Amount'].		"',
			'".$Lot['Percent'].	"',
			'".$Lot['duration'].	"',
			'".$Lot['CreditorId'].	"',
			'".$userId.				"',
			'".date("Y-m-d H:i:s").	"'
		)";
		
		
		if ($result = $connection->query($query)){
			//echo mysqli_error($connection);
			$query = "DELETE FROM Lot WHERE LotId=".$_GET['id'];
			if ($result = $connection->query($query)){
				header('Location: /');
			}
		}																							
	}
?>