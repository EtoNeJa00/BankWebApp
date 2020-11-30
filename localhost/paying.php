<?php
	require_once "includes/config.php";
	require_once "includes/db.php";
	
	/*echo $query."<br>";var_dump($_POST);
	echo "<br>";
	var_dump($Conditions);*/
	
	$SearchRes = array();
	$CreditCount;
	$user = getUser();
	
	$query 	= "SELECT * FROM takenlot WHERE DebtorId=".$_SESSION['logged_user']['UserId'];
		
	$result = $connection->query($query);
	echo mysqli_error($connection);
	
	$creditSum=0;
	$recomPaySum=0;
	
	while ($lot = $result->fetch_assoc())
	{
		$TimeStart = strtotime($lot["TakeDate"]);
		$timeToEnd = ( $TimeStart+$lot["Duration"]*60*60*24-time())/60/60/24;
		$recomPay = round($lot["Amount"]/$timeToEnd, 2);
		
		$recomPaySum += $recomPay;
		$creditSum += $lot["Amount"];

		/*echo $recomPay;
		echo "<br>";*/
		$lotAddit = array('recomPay'=>$recomPay);
		$SearchRes[] = $lot+$lotAddit;
	}
	
	$recomPaySum = round($recomPaySum, 2);
	
	$CreditCount=count($SearchRes);
	//var_dump($SearchRes);
?>

<head>
	<title> Банк </title>
	<link href="style.css" rel="stylesheet">
	<script  type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
</head>
<body>
<div class="grid">
	<header><a href="/index.php">Главная</a><br></header>
	
	<article>
		<?php for($i=0;$i<count($SearchRes);$i++):?>
		
		<div class="TekeLot">
			<h1>Сумма: <?php echo $SearchRes[$i]['Amount']; ?></h1>
			Процент: <?php echo $SearchRes[$i]['Percent']; ?>%<br>
			Срок: <?php echo $SearchRes[$i]['Duration']; ?> дней<br>
			
		<form action="pay.php" method="POST">	
			<input type="hidden" name="id" value="<?php echo $SearchRes[$i]['TakenLotId']; ?>">
			Заплатить: 
			<input type="number" name="pay" min="0" 
				max="<?php echo $SearchRes[$i]['Amount']; ?>"
				value="<?php echo $SearchRes[$i]['recomPay']; ?>"
				step="0.01"><br>
			<button type="submit" id="pay">Оплатить</button>
		</form>
		</div>
		<?php endfor; ?>
	</article>
	
	<aside>
		Сумма кредитов: <?php echo $creditSum; ?></h1><br>	
		Число кредитов: <?php echo $CreditCount; ?></h1><br>
		Примерный платёж: <?php echo $recomPaySum; ?></h1><br>
		Сумма на счету: <?php echo $user["Money"] ?></h1><br>
    </aside>
	<footer><?php echo $footer; ?></footer>
</div>

</body>