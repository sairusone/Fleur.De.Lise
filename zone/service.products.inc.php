	<form action="" method="POST" enctype="multipart/form-data">

		<input type="hidden" name="products">
		<br>
		<?php

			# ЕСЛИ НАЖАТА КНОПКА ДЛЯ ДОБАВЛЕНИЯ ТОВАРА
			if ( isset($_POST['prodAdd']) )
			{
				$productName		= $_POST['prodName'];
				$productCats		= $_POST['prodCats'];
				$productPrice		= $_POST['prodPrice'];
				$productImageName 	= $_FILES['prodImage']['name'];



				if ( (isset($productImageName) && !empty($productImageName)) && !empty($productName) && !empty($productCats) && !empty($productPrice) )
				{

					$imageNewName 		= time();
					$imageExtesion 		= substr($productImageName, strpos($productImageName, '.') + 1);
					$productImageName	= $imageNewName . '.' . $imageExtesion;

					$imageNewLocation = '../content/';
					$imageTmpLocation = $_FILES['prodImage']['tmp_name'];

					$availibleTypes = array('image/jpeg', 'image/jpg', 'image/png');

					if ( $_FILES['prodImage']['type'] == 'image/jpeg' )
					{

						db::dbQuery("INSERT INTO `content` (`name`,`cats`,`price`,`image`) VALUES ('$productName', '$productCats', $productPrice, '$productImageName')", false, false);
						move_uploaded_file($imageTmpLocation, $imageNewLocation . $productImageName);

						echo "<b>БУКЕТ УСПЕШНО ДОБАВЛЕН!</b>";
					}
					else
					{
						echo "<b style='color: red'>ФАЙЛ ДОЛЖЕН БЫТЬ ТИПА JPEG/JPG ИЛИ PNG!</b>";
					}

					
				}
				else
				{
					echo "<b style='color: red'>ДЛЯ ДОБАВЛЕНИЯ БУКЕТА - ВВЕДИТЕ НАЗВАНИЕ, ЕГО ЦЕНУ,<br>ВЫБЕРИТЕ ФОТОГРАФИЮ И КАК МИНИМУМ ОДНУ КАТЕГОРИЮ!</b>";
				}

				

			}
			# ЕСЛИ НАЖАТА КНОПКА ДЛЯ УДАЛЕНИЯ ТОВАРА
			elseif ( isset($_POST['prodDelete']) )
			{
				$productID 			= (int)$_POST['productID'];
				$productImageName 	= $_POST['prodSelectImage'];

				$imageLocation 		= '../content/';

				if ($productID != 0)
				{
					db::dbQuery("DELETE FROM `content` WHERE `id` = $productID", false, false);

					unlink( $imageLocation . $productImageName );

					echo "<b>БУКЕТ УСПЕШНО УДАЛЕН!</b>";
				}

				
			}
		?>
		<br>
		<br>
		<section class="left">
			Список товаров:<br>
			<select name="productID">
				<?php

					$allProducts = db::dbQuery('SELECT * FROM `content`', False);

					$firstProduct = @mysql_fetch_array($allProducts);
					echo '<option value="' . $firstProduct['id'] . '">Букет "' . $firstProduct['name'] . '"</option>';

					while ( $product = @mysql_fetch_array($allProducts) )
					{
						echo '<option value="' . $product['id'] . '">Букет "' . $product['name'] . '"</option>';
					}

				?>
			</select><br>
			<img src="../content/<?=$firstProduct['image']?>" width=150><br>
			<input type="hidden" name="prodSelectImage" value="<?=$firstProduct['image']?>" />

			<i>Товар находится в категориях:<br>
			<?php

				# ЗАПРОС НА НАЗВАНИЯ КАТЕГОРИЙ, ИМЕЮЩИХСЯ В БУКЕТАХ, ИХ КОЛИЧЕСТВО И ВЫВОД

				if ( !empty($firstProduct['cats']) ) 
				{
					$allCategories = @db::dbQuery("SELECT * FROM `categories` WHERE `id` IN (" . $firstProduct['cats'] .")", false);
					$allCategoriesCount = @mysql_num_rows($allCategories);
					
					for ($i=0; $i < $allCategoriesCount; $i++)
					{ 

						echo '<b>' . mysql_result($allCategories, $i, 'name') . '</b>';

						# ЕСЛИ ЭТО НЕ ПОСЛЕДНЯЯ КАТЕГОРИЯ - СТАВИМ ЗАПЯТУЮ В КОНЦЕ
						if ($i+1 != $allCategoriesCount) {
							echo ", ";
						}
					}
				}
			?>
			</i>
		</section>

		<section class="right">
			<b>Добавить товар:</b><br>
			Название букета:<br>
			<input type="text" name="prodName"><br><br>

			Стоимость букета:<br>
			<input type="text" name="prodPrice"><br><br>

			Фотография:<br>
			<input type="file" name="prodImage"><br><br>

			Категории нового букета:<br>
			<select name="prodCatsList" multiple="">
			<?php
				$allCategories = db::dbQuery('SELECT * FROM `categories`', False);

				while ( $category = mysql_fetch_array($allCategories) )
				{
					echo '<option value="' . $category['id'] . '" />' . $category['name'] . '</option>';
				}
			?>
			</select><br>
			<input type="hidden" value="" name="prodCats">

			<input type="submit" value="Добавить букет" name="prodAdd"><br><br>

			
			<b>Удалить товар:</b><br>
			<input type="submit" value="Удалить" name="prodDelete">

			<div class="information">
			* Если товар относится к нескольким категориям - выберите их в списке нажав клавишу <b>Ctrl</b><br><br>
			* Для удаления товара - выберите его слева и нажмите на кнопку "Удалить"
			</div>
		</section>
	</form>

	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<script type="text/javascript" src="products.js"></script>