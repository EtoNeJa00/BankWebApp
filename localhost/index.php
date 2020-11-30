<?php
	require_once "includes/config.php";
	require_once "includes/db.php";
	
	$user = getUser();
	
	function getCondition($column, $from, $to)
	{
		if(($from==null) and($to==null))
		{
			$Condition="";
		}
		else if($to==null)
		{
			$Condition="".$column." > ".$from."";
		}
		else if($from==null)
		{
			$Condition="".$column." < ".$to."";
		}
		else
		{
			$Condition="".$column." > ".$from." AND ".$column."<".$to."";
		}
		
		return $Condition;
	}
	
	$Conditions = array(
	getCondition('Amount', $_POST['SrCount_from'], $_POST['SrCount_to']),
	getCondition('Percent', $_POST['SrPerc_from'], $_POST['SrPerc_to']),
	getCondition('duration', $_POST['SrDays_from'], $_POST['SrDays_to']));
	

	
	for($i=count($Conditions)-1;$i>=0; $i--)
	{
		if ($Conditions[$i]=="")
		{
			unset($Conditions[$i]);
		}
	}
	
	
	$SearchRes = array();
	
	$Conditions = array(
	getCondition('Amount', $_POST['SrCount_from'], $_POST['SrCount_to']),
	getCondition('Percent', $_POST['SrPerc_from'], $_POST['SrPerc_to']),
	getCondition('duration', $_POST['SrDays_from'], $_POST['SrDays_to']));

	for($i=count($Conditions)-1;$i>=0; $i--)
	{
		if ($Conditions[$i]=="")
		{
			unset($Conditions[$i]);
		}
	}

	$where="";
	if (count($Conditions)>0)
	{
		$where =  " WHERE ";
	}
	
	if (isset ($_SESSION['logged_user']))
	{
		$query = "SELECT * FROM lot WHERE CreditorId!=".$user['UserId'].join(" AND ",$Conditions);
	}
	else 
	{
		$query = "SELECT * FROM lot".$where.join(" AND ",$Conditions);
	}
	$result = $connection->query($query);
	
	while ($lot = $result->fetch_assoc())
	{
		$SearchRes[]= $lot;
	}
	//var_dump($SearchRes);
?>

<head>
	<title> Банк </title>
	<link href="style.css" rel="stylesheet">
	<script  type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.js"></script>
	<script  type="text/javascript" src="js/index.js"></script>
</head>
<body>
<div class="grid">
	<header>
	
	<?php if ( isset ($_SESSION['logged_user'])):?>
	<a href="/paying.php">Оплата кредитов</a><br>
	<?php endif;?>
	
	</header>
  <div class = "LotCr">
  <form>
  
    Сумма:
		<input type="number" id="count" step="0.01"><br>
    Процент:
		<input type="number" id="percent" step="0.1">%<br>
    Срок (дней): 
		<input type="Number" id="days" step="1">
		
	<button type="button" id="createLot">Создать</button>
	
  </form>
  <div id="errorLC"></div>
  </div>
  
  <div id = "LogIn">
 <?php if ( isset ($_SESSION['logged_user'])):?>
 
	Добро пожаловать, <?php echo $_SESSION['logged_user']['UserLogin'];?><br>
	Ваши средства: <?php echo $user['Money'];?><br>
	<a href="/logout.php">Выйти</a>
	
<?php else:?>

	<a href="/login.php">Войти</a><br>
	<a href="/signin.php">Зарегистрироваться</a><br>
	
<?php endif;?>
	
  </div>
	<article>
		<?php for($i=0;$i<count($SearchRes);$i++):?>
		
		<div class="Lot">
			<h1>Сумма: <?php echo $SearchRes[$i]['Amount']; ?></h1>
			Процент: <?php echo $SearchRes[$i]['Percent']; ?>%<br>
			Срок: <?php echo $SearchRes[$i]['duration']; ?> дней
			<input type="button" value="Взять" onclick="location.href='takaLot.php?id=<?php echo $SearchRes[$i]['LotId']; ?>'"><br>	
		</div>
		
		<?php endfor; ?>
	</article>
	
	<aside>
	<form action="index.php" method="POST">
		Сумма: <br>
			<input type="text" name="SrCount_from" 	placeholder="от">	
			<input type="text" name="SrCount_to" 		placeholder="до"><br>
		                       
		Процент: <br>          
			<input type="text" name="SrPerc_from" 	placeholder="от">
			<input type="text" name="SrPerc_to"	 	placeholder="до"><br>
		                       
		Срок (дней):  <br>     
			<input type="text" name="SrDays_from" 	placeholder="от">
			<input type="text" name="SrDays_to" 		placeholder="до"><br>
		
		<input type="submit" name="do_Search" value="найти"><br>		
	</form>

    </aside>
	<footer><?php echo $footer; ?></footer>
</div>

</body>