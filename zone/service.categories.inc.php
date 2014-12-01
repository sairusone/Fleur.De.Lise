	<form action="" method="POST">

		<input type="hidden" name="categories">
		<br>
		<?php

			# ЕСЛИ НАЖАТА КНОПКА ДЛЯ ДОБАВЛЕНИЯ КАТЕГОРИИ
			if ( isset($_POST['catAdd']) )
			{

				db::dbQuery("INSERT INTO `categories` (`name`) VALUES ('".$_POST['catNameAdd']."')",false,false);

				echo "<b>КАТЕГОРИЯ УСПЕШНО ДОБАВЛЕНА!</b>";

			}
			# ЕСЛИ НАЖАТА КНОПКА ДЛЯ ИЗМЕНЕНИЯ КАТЕГОРИИ
			elseif ( isset($_POST['catChange']) )
			{
				//echo $_POST['catID'];
				db::dbQuery("UPDATE `categories` SET `name` = '".$_POST['catNameChange']."' WHERE `id` = " . $_POST['catID'],false,false);

				echo "<b>ИМЯ КАТЕГОРИИ УСПЕШНО ИЗМЕНЕНО!</b>";
			}
			# ЕСЛИ НАЖАТА КНОПКА ДЛЯ УДАЛЕНИЯ КАТЕГОРИИ
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
			Список категорий:<br>
			<select name="catID">
				<?php

					# ВЫВОДИМ СПИСОК ИМЕЮЩИХСЯ КАТЕГОРИЙ
					$allCategories = db::dbQuery('SELECT * FROM `categories`', False);

					while ( $category = mysql_fetch_array($allCategories) )
					{
						echo '<option value="' . $category['id'] . '">' . $category['name'] . '</option>';
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