<?php
	require_once "includes/config.php";
	require_once "includes/db.php";
	
	$data = $_POST;
	if(isset($data['do_signup']))
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
		
		if($data['pas2']!= $data['pas'] )
		{
			$errors[]='пароли не совпадают';
		}
		
		if(empty($errors))
		{
			$query ="INSERT INTO user (UserLogin,Password) VALUES ('".$data['login']."','".md5($data['pas'])."')";
			$sql=mysqli_query($connection, $query);
			    if ($sql) {
					echo '<p>Регистрация произошла!</p>';
				} else {
					echo '<p>Произошла ошибка: ' . mysqli_error($connection) . '</p>';
				}
		}
		else
		{
			echo '<div style="color:red;">'.array_shift($errors).'</div><hr>';
		}
	}
?>

<form action="signin.php" method="POST">
	<p>
		<p><strong>Логин:</strong></p>
		<input type="text" name="login" value="<?php echo @$data[login];?>"><br>
	</p>
	<p>
		<p><strong>Пароль:</strong></p>
		<input type="password" name="pas" value="<?php echo @$data[pas];?>"><br>
	</p>
	<p>
		<p><strong>Пароль ещё раз:</strong></p>
		<input type="password" name="pas2" value="<?php echo @$data[pas2];?>"><br>
	</p>
	
	<p><input type="submit" name="do_signup" value="Регистрация"><br></p>	
</form>
