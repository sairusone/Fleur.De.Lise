<?php

############################################################
############################################################
###
### КЛАСС РАБОТЫ С КОРЗИНОЙ
### --------------------------------------------------------
### Поддержка AJAX: ДА
###
############################################################
############################################################

session_start(1);

if ( isset($_POST['shopCommand']) )
{
	require_once('../classes/db.class.php');
}
else
{
	require_once('classes/db.class.php');
}


# ВЫБОР КОМАНДЫ
switch ( htmlentities($_POST['shopCommand']) )
{
	case 'addProduct':
		echo addProduct( (int)$_POST['productID'] );
		break;

	case 'removeProduct':
		echo removeProduct();
		break;

	case 'listProduct':
		echo getProductList();
		break;

	case 'changeCount':
		echo changeProductCount();
		break;

	default:
		echo 'False, 0';
		break;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# ДОБАВЛЕНИЕ ТОВАРА В КОРЗИНУ
#######################################################
// ВОЗВРАТ = 'True, <СТОИМОСТЬ ТОВАРОВ>'
function addProduct( $productID )
{
	# ЗАПРОС В БД О СТОИМОСТИ ТОВАРА
	$productPrice = db::dbQuery('SELECT `price` FROM `content` WHERE `id` = ' . (int)$productID);


	//$_SESSION['productsCount'];
	//$_SESSION['totalCount'];
	//$_SESSION['totalPrice'];
	//$_SESSION['productsList'];

	# ЗАПОМИНАЕМ КОЛИЧЕСТВО ТОВАРОВ В КОРЗИНЕ, ПРИБАВЛЯЕМ К НИМ ОДИН И ФИКСИРУЕМ
	$_SESSION['totalCount']++;
	$_SESSION['productsCount']++;

	# ДОБАВЛЯЕМ ТОВАР В КОРЗИНУ
	$_SESSION['productsList'][ (int)$productID ]++;

	# ЗАПОМИНАЕМ ОБЩУЮ СТОИМОСТЬ ТОВАРОВ В КОРЗИНЕ, ПРИБАВЛЯЕМ К НЕЙ СТОИМОСТЬ НОВОГО, ДОБАВЛЕННОГО ТОВАРА И ФИКСИРУЕМ
	$_SESSION['totalPrice'] += (int)$productPrice['price'];


	# ВОЗВРАЩЕНИЕ РЕЗУЛЬТАТА
	return 'True,' . $_SESSION['totalCount'] . ',' . $_SESSION['totalPrice'];
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# УДАЛЕНИЕ ТОВАРА ИЗ СПИСКА КОРЗИНЫ ПОКУПОК
#######################################################
// ВОЗВРАТ = 'True, <СТОИМОСТЬ ТОВАРОВ>'
function removeProduct()
{
	$productID = (int)$_POST['productID'];

	$productPrice = db::dbQuery('SELECT `price` FROM `content` WHERE `id` = ' . $productID);
	$productPrice = $productPrice['price'];

	$_SESSION['productsCount']--;
	$_SESSION['totalCount'] -= $_SESSION['productsList'][ $productID ];
	$_SESSION['totalPrice'] -= $_SESSION['productsList'][ $productID ] * $productPrice;

	unset($_SESSION['productsList'][ $productID ]);

	$returnString = 'True,' . $_SESSION['totalCount'] . ',' . $_SESSION['totalPrice'];

	# ВОЗВРАЩЕНИЕ РЕЗУЛЬТАТА
	return $returnString;

}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# СПИСОК ТОВАРОВ В КОРЗИНЕ
#######################################################
// ВОЗВРАТ = 'True, <КОЛИЧЕСТВО ТОВАРОВ>, <СПИСОК ТОВАРОВ (<ID>|<НАЗВАНИЕ>|<СТОИМОСТЬ>)>'
function getProductList()
{
	# ПРОВЕРКА НА НАЛИЧИЕ СПИСКА ТОВАРОВ, ДОБАВЛЕННЫХ В КОРЗИНУ
	if ( (int)$_SESSION['totalCount'] != 0 )
	{

		$returnString = 'True|';
		foreach ($_SESSION['productsList'] as $key => $value)
		{

			$productInfo = db::dbQuery('SELECT * FROM `content` WHERE `id` = ' . $key);

			$returnString .= '<tr id="' . $productInfo['id'] . '"><td>Букет "' . $productInfo['name'] . '"</td><td>' . $productInfo['price'] . '</td><td class="basketCount">' . $value . '</td><td class="basketTotalPrice">' . ( (int)$productInfo['price'] * $value ) . '</td><td class="basketDelete">Удалить</td></tr>';

		}


	}
	else
	{
		# ФОРМИРУЕМ РЕЗУЛЬТИРУЮЩУЮ СТРОКУ С ОШИБКОЙ
		$returnString = 'False|<center>Корзина пуста</center>';
	}

	
	return $returnString;
}



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

# ИЗМЕНЕНИЕ КОЛИЧЕСТВА ТОВАРА В КОРЗИНЕ
#######################################################
// ВОЗВРАТ = 'True, <КОЛИЧЕСТВО ТОВАРОВ>, <СПИСОК ТОВАРОВ (<ID>|<НАЗВАНИЕ>|<СТОИМОСТЬ>)>'
function changeProductCount()
{
	
	$productID		= (int)$_POST['productID'];
	$countValue		= (int)$_POST['countValue'];

	if ( $countValue != 0 )
	{
		$productPrice = db::dbQuery('SELECT `price` FROM `content` WHERE `id` = ' . $productID);
		$productPrice = (int)$productPrice['price'];

		
		$_SESSION['totalCount']					-= $_SESSION['productsList'][ $productID ];
		$_SESSION['totalPrice']					-= $_SESSION['productsList'][ $productID ] * $productPrice;
		$_SESSION['totalCount']					+= $countValue;
		$_SESSION['totalPrice']					+= $countValue * $productPrice;
		$_SESSION['productsList'][ $productID ]  = $countValue;

		$returnString = 'True,' . $countValue * $productPrice . ',' . $_SESSION['totalCount'] . ',' . $_SESSION['totalPrice'];
	}
	else
	{
		$returnString = 'False,Количество товара не изменено. Введите количество больше 0. Если вы хотите отказаться от товара - нажмите на "Удалить" в строке товара';
	}
	
	return $returnString;
}