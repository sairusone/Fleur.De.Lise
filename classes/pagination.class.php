<?php

require_once('db.class.php');

switch ($_POST['command'])
{
	case 'getPagination':
		getPagination();
		break;
	
	default:
		# code...
		break;
}



function getPagination()
{
	$categoriesIDs 	= $_POST['categoriesIDs'];
	$priceSign		= $_POST['priceSign'];
	$priceCost		= $_POST['priceCost'];
	$pagination		= substr($_POST['pagination'], strpos($_POST['pagination'], ',') + 1);
	$pagination 	= strrev( substr( strrev($pagination) , 1) );

	
	# ПРОВЕРЯЕМ - ПОДБОРКА ТОВАРОВ ИЛИ НЕТ
	if ( $categoriesIDs == '%' && ($priceCost == 0 && $priceSign == '>') )
	{
		# ВСЕ ТОВАРЫ
		$paginationCount = db::dbQuery("SELECT COUNT(*) FROM `content` ORDER BY `id` DESC", true, false);
		
	}
	else
	{
		# ЕСЛИ ВЫБРАНЫ КАТЕГОРИИ В ПОДБОРКЕ
		if ($categories <> '%')
		{
			$whereString = "`cats` LIKE '$categoriesIDs' AND";
		}

		# СОСТАВЛЯЕМ ЗАПРОС
		$paginationCount = db::dbQuery("SELECT COUNT(*) FROM `content` WHERE $whereString `price` $priceSign" . (int)$priceCost . " ORDER BY `id` DESC", true, false);
		
		
	}

	$paginationCount = $paginationCount[0] / 10;
	$paginationCount = ceil($paginationCount);


	$triplePointAlreadyExist = false;

	for ($i=1; $i <= $paginationCount; $i++)
	{ 
		//echo $i-1 . '0,' . $i . '0<br>';
		//echo $pagination . '==' . $i . '0';
		$identifier = ($i-1 == 0) ? '0,' . $i . '0' : $i-1 . '0,' . $i . '0';
			//echo $i >= $paginationCount - 2 . '<br>';
		//echo $i;
		if ( ($i <= 2) || ( ($i == $pagination - 1) || ($i == $pagination) || ($i == $pagination + 1) ) || $i >= $paginationCount - 1 ) {
			
			if ($pagination == $i)
			{
				
				echo "<a href='#' class='pagination inactive' id='$identifier'>" . $i . "</a>";
			}
			else
			{
					echo "<a href='#' class='pagination' id='$identifier'>" . $i . "</a>";
			}
				$triplePointAlreadyExist = false;
		}
		else
		{
			if ($triplePointAlreadyExist == false)
			{
				echo '&nbsp;...&nbsp;';
				$triplePointAlreadyExist = true;
			}
			
		}
			
	}
}


?>