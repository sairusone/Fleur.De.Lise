<?php

	session_start();

	if (isset($_SESSION['admin.logged.in']) && $_SESSION['admin.logged.in'] == true) {
		require('secret_admin_main_zone.php');
		die();
	}


	if ( isset($_POST['submit']) ) {
		
		if ( (isset($_POST['username']) && !empty($_POST['username'])) && (isset($_POST['password']) && !empty($_POST['password']))) {
			
			if ($_POST['username'] == 'Administrator' && $_POST['password'] == 'OlgaGlobalAdmin') {
				

				$_SESSION['admin.logged.in'] = true;
				header('Location:' . '/zone');
			}

		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Fleur de Lis - букеты на любой вкус! :: Административная зона</title>

	<!-- ОБЪЯВЛЕНИЕ МЕТА-ТЕГОВ -->
	<meta charset="utf-8">

</head>

<body>
<center>

	<form action="" method="POST">

	Пользователь: <br><input type="text" name="username"><br>
	Пароль: <br><input type="password" name="password"><br>
	<input type="submit" value="Войти" name="submit">

	</form>

</center>
</body>