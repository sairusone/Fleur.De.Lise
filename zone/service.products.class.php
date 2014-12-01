<?php

require_once('../classes/db.class.php');


switch ($_POST['command'])
{
	case 'getCategoriesList':
		getCategoriesList();
		break;
	case 'getProductImage':
		getProductImage();
		break;
	
	default:
		# code...
		break;
}


function getCategoriesList()
{
	$productID = $_POST['productID'];

	$categoriesIDs = db::dbQuery('SELECT `cats` FROM `content` WHERE `id` = ' . $productID);

	# ЗАПРОС НА НАЗВАНИЯ КАТЕГОРИЙ, ИМЕЮЩИХСЯ В БУКЕТАХ, ИХ КОЛИЧЕСТВО И ВЫВОД
	$allCategories = db::dbQuery("SELECT * FROM `categories` WHERE `id` IN (" . $categoriesIDs['cats'] .")", false);
	$allCategoriesCount = mysql_num_rows($allCategories);
				
	for ($i=0; $i < $allCategoriesCount; $i++)
	{ 

		echo '<b>' . mysql_result($allCategories, $i, 'name') . '</b>';
		
		# ЕСЛИ ЭТО НЕ ПОСЛЕДНЯЯ КАТЕГОРИЯ - СТАВИМ ЗАПЯТУЮ В КОНЦЕ
		if ($i+1 != $allCategoriesCount) {
			echo ", ";
		}
	}
}

function getProductImage()
{
	$productID = $_POST['productID'];

	$productImage = db::dbQuery('SELECT `image` FROM `content` WHERE `id` = ' . $productID);

	echo $productImage['image'];
}

?>