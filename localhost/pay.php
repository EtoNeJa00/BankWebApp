<?php 
	require_once "includes/config.php";
	require_once "includes/db.php";


	$user = getUser();
	$recipient;

	if(!$user)
	{
		header('Location: /');
	}
	
	$query 	= "SELECT * FROM takenlot WHERE TakenLotId=".$_POST['id'];
	$result = $connection->query($query);
	
	$lot = $result->fetch_assoc();
	
	if (!$lot)
	{
		header("Location:/paying.php");
	}
	
	$query = "SELECT * FROM user WHERE UserId='".$lot['CreditorId']."'";
	if ($result = $connection->query($query)){
		$recipient = $result->fetch_assoc();
	}
	else 
	{
		header("Location:/paying.php");
	}
	
	if($user["Money"]<$_POST["pay"])
	{
		header("Location:/paying.php");
	}else if($lot["Amount"]==$_POST["pay"])
	{
		Transaction($user, $recipient, $_POST["pay"]);
		$query = "DELETE FROM takenlot WHERE TakenLotId=".$_POST['id'];
		$connection->query($query);
	}else{
		Transaction($user, $recipient, $_POST["pay"]);
		
		$query = "UPDATE takenlot
			SET Amount = Amount-".$_POST["pay"]."
			WHERE TakenLotId=".$_POST['id'];
			
		 $connection->query($query);
	}
	header("Location:/paying.php");
	
	function Transaction($Creditor, $Debtor, $amount)
	{
		global $connection;
		$query = "UPDATE user
			SET Money = Money+".$amount."
			WHERE UserId = ".$Debtor["UserId"];
			
		 $connection->query($query);
			$query = "UPDATE user
			SET Money = Money-".$amount."
			WHERE UserId = ".$Creditor["UserId"];
		$connection->query($query);
			
		
	}
?>