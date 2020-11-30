<?php
	require_once "includes/config.php";
	require_once "includes/db.php";
	
	$data = $_POST;
	if(isset($data['do_login']))
	{
		$errors = array();
		if(trim($data['login'])=='')
		{
			$errors[]='введите логин';
		}
		
		if(trim($data['pas'])=='')
		{
			$errors[]='введите пароль';
		}
		
		if(empty($errors))
		{
			$query  = "SELECT * FROM user WHERE BINARY UserLogin='".$data['login']."' AND BINARY Password='".md5($data['pas'])."'";
			if ($result = $connection->query($query)){
				$User = $result->fetch_assoc();
				
				$_SESSION['logged_user']=$User;
				header('Location: /');
			}
		}
		else
		{
			echo '<div style="color:red;">'.array_shift($errors).'</div><hr>';
		}
	}
?>

<form action="login.php" method="POST">
	<p>
		<p><strong>Логин:</strong></p>
		<input type="text" name="login" value="<?php echo @$data[login];?>"><br>
	</p>
	<p>
		<p><strong>Пароль:</strong></p>
		<input type="password" name="pas" value="<?php echo @$data[pas];?>"><br>
	</p>
	
	<p><input type="submit" name="do_login" value="Войти"><br></p>	
</form>
