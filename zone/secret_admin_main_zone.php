<?php
	# РАБОТА С СЕССИЕЙ
	session_start();

	# ЕСЛИ НАЖАТА КНОПКА "ВЫХОД" - ЗАВЕРШАЕМ СЕССИЮ И ОБНОВЛЯЕМ СТРАНИЦУ
	if ( isset($_POST['exit']) )
	{
		
		session_destroy();
		header('Location:' . '/zone');

	}

	# ВКЛЮЧАЕМ КЛАСС ДЛЯ РАБОТЫ С БАЗОЙ ДАННЫХ
	require_once('../classes/db.class.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Fleur de Lis - букеты на любой вкус! :: Административная зона</title>

	<!-- ОБЪЯВЛЕНИЕ МЕТА-ТЕГОВ -->
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
<center>
<section id="main_section">

	<form action="" method="POST">

	<input type="submit" value="Категории" name="categories">
	<input type="submit" value="Товары" name="products">
	|||||||||||||||||||||||||||||||||||||||||||||||||||||
	|||||||||||||||||||||||||||||||||||||||||||||||||||||
	|||||||||||||||||||||||||||||||||||||||||||||||||||||
	<input type="submit" value="Выйти" name="exit">

	</form>

	<div id="content">
		
	<?php

		# ПРОВЕРЯЕМ, НАЖАТА ЛИ КАКАЯ-ЛИБО КНОПКА МЕНЮ
		if ( isset($_POST['categories']) )
		{
			# ЕСЛИ В МЕНЮ НАЖАТА КНОПКА "КАТЕГОРИИ" - РАБОТА С КАТЕГОРИЯМИ
			require_once('service.categories.inc.php');
		}
		elseif ( isset($_POST['products']) )
		{
			# ЕСЛИ В МЕНЮ НАЖАТА КНОПКА "ПРОДУКТЫ" - РАБОТА С ПРОДУКТАМИ
			require_once('service.products.inc.php');
		}
		else
		{
			# ЕСЛИ НЕТ - ТЕКСТ ПО-УМОЛЧАНИЮ
			echo "Выберите категорию выше";
		}



		
	function editProducts()
	{
	?>
	<form action="" method="POST">

		<input type="hidden" name="products">
		<br>
		<?php
			if ( isset($_POST['catAdd']) )
			{

				db::dbQuery("INSERT INTO `categories` (`name`) VALUES ('".$_POST['catNameAdd']."')",false,false);

				echo "<b>КАТЕГОРИЯ УСПЕШНО ДОБАВЛЕНА!</b>";

			}
			elseif ( isset($_POST['catChange']) )
			{
				//echo $_POST['catID'];
				db::dbQuery("UPDATE `categories` SET `name` = '".$_POST['catNameChange']."' WHERE `id` = " . $_POST['catID'],false,false);

				echo "<b>ИМЯ КАТЕГОРИИ УСПЕШНО ИЗМЕНЕНО!</b>";
			}
			elseif ( isset($_POST['catDelete']) )
			{
				//echo $_POST['catID'];
				db::dbQuery("DELETE FROM `categories` WHERE `id` = " . $_POST['catID'],false,false);

				echo "<b>КАТЕГОРИЯ УСПЕШНО УДАЛЕНА!</b>";
			}
		?>
		<br>
		<br>
		<section class="left">
			Список товаров:<br>
			<select name="catID">
				<?php

					$allProducts = db::dbQuery('SELECT * FROM `content`', False);

					while ( $product = mysql_fetch_array($allProducts) )
					{
						echo '<option value="' . $product['id'] . '">Букет "' . $product['name'] . '"</option>';
					}

				?>
			</select>
		</section>

		<section class="right">
			Добавить категорию:<br>
			<input type="text" name="catNameAdd">
			<input type="submit" value="Добавить" name="catAdd"><br><br>
			Изменить категорию:<br>
			<input type="text" name="catNameChange">
			<input type="submit" value="Изменить" name="catChange"><br><br>
			Удалить категорию:<br>
			<input type="submit" value="Удалить" name="catDelete">

			<div class="information">
			* Для изменения названия категории - выберите категорию слева, введите в поле "Изменить категорию" новое название и нажмите на кнопку "Изменить"<br><br>
			* Для удаления категории - выберите категорию слева и нажмите на кнопку "Удалить"
			</div>
		</section>
	</form>
	<?php
	}

	?>

	</div>

</section>
</center>
</body>