<?php

############################################################
############################################################
###
### КЛАСС ВЫВОДА ТОВАРОВ
### --------------------------------------------------------
### Поддержка AJAX: ДА
###
############################################################
############################################################

if ( isset($_POST['command']) )
{
	require_once('../classes/db.class.php');
}
else
{
	require_once('classes/db.class.php');
}


# ВЫБОР КОМАНДЫ
switch ( htmlentities($_POST['command']) )
{
	case 'getProductsList':
		# ЭКРАНИРУЕМ СПЕЦ. СИМВОЛЫ
		$reqPagination	=	htmlspecialchars( htmlentities($_POST['reqPagination'])	);
		$reqCategories	=	$_POST['reqCategories'];
		$reqCoastSign	=	$_POST['reqCoastSign'];
		$reqCoastPrice	=	htmlspecialchars( htmlentities($_POST['reqCoastPrice'])	);

		getProductsList($reqPagination, $reqCategories, $reqCoastSign, $reqCoastPrice);
		break;
}

# ПЕРВОЕ ОТОБРАЖЕНИЕ СПИСКА ТОВАРОВ НА ГЛАВНОЙ СТРАНИЦЕ
function getProductsList($pagination = '0,10', $categories = '%%', $coastSign = '>', $coastPrice = '0')
{
	# ЭКРАНИРУЕМ СПЕЦ. СИМВОЛЫ
	$pagination = $pagination;
	$categories = $categories;
	$coastSign 	= $coastSign;
	$coastPrice = $coastPrice;


	# ПРОВЕРЯЕМ - ПОДБОРКА ТОВАРОВ ИЛИ НЕТ
	if ( $categoriesIDs == '%' && ($priceCost == 0 && $priceSign == '>') )
	{
		# ВЫБОРКА ТОВАРОВ
		$allProducts = db::dbQuery("SELECT * FROM `content` ORDER BY `id` DESC LIMIT $pagination", false);
		}
	else
	{
		# ЕСЛИ ВЫБРАНЫ КАТЕГОРИИ В ПОДБОРКЕ - ЗАПОЛНЯЕМ СТРОКУ НА ПОДБОР ТОВАРОВ ИЗ КАТЕГОРИЙ
		if ($categories <> '%')
		{
			$whereString = "`cats` LIKE '$categories' AND";
		}

		# СОСТАВЛЯЕМ ЗАПРОС
		$allProducts = db::dbQuery("SELECT * FROM `content` WHERE $whereString `price` $coastSign" . (int)$coastPrice . " ORDER BY `id` DESC LIMIT $pagination", false, false);
	}
	

	if ( mysql_num_rows($allProducts) == 0 )
	{
		echo '<center>Товаров с указанными параметрами не найдено</center>';
	}
	# ПРОБЕГАЕМ ПО ВСЕМ ПОЗИЦИЯМ, ФОРМИРУЯ ВЫВОД
	while ($product = mysql_fetch_array($allProducts))
	{
		?>

		<span class="element" id="<?=$product['id'];?>">
		<img src="content/<?=$product['image'];?>">
		<span>
		<u>Букет "<?=$product['name'];?>"</u>
		Категории:
		<?php

			# ЗАПРОС НА НАЗВАНИЯ КАТЕГОРИЙ, ИМЕЮЩИХСЯ В БУКЕТАХ, ИХ КОЛИЧЕСТВО И ВЫВОД
			$allCategories = db::dbQuery("SELECT * FROM `categories` WHERE `id` IN (" . $product['cats'] .")", false);
			$allCategoriesCount = mysql_num_rows($allCategories);
			
			for ($i=0; $i < $allCategoriesCount; $i++)
			{ 

				echo '<b>' . mysql_result($allCategories, $i, 'name') . '</b>';

				# ЕСЛИ ЭТО НЕ ПОСЛЕДНЯЯ КАТЕГОРИЯ - СТАВИМ ЗАПЯТУЮ В КОНЦЕ
				if ($i+1 != $allCategoriesCount) {
					echo ", ";
				}
			}
			
		?>

		</span>
		<a href="#" class="buyButton" id="<?=$product['id'];?>">
		<i>В корзину</i>
		<?=$product['price'];?><b>руб.</b>
		</a>
		</span>

	<?php
	}

}


