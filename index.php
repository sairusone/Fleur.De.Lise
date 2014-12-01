<?php
session_start(1);
//session_destroy();
# ОПРЕДЕЛЕНИЕ ГЛОБАЛЬНЫХ ПЕРЕМЕННЫХ
require("classes/define.class.php");


require("classes/static_information.class.php");
require("classes/products.class.php");


# ПРОВЕРКА НА УЖЕ СУЩЕСТВУЮЩИЕ ЭЛЕМЕНТЫ В КОРЗИНЕ

	# КОЛИЧЕСТВО БУКЕТОВ В КОРЗИНЕ
	if ( isset($_SESSION['totalCount']) && $_SESSION['totalCount'] <> 0 )
	{
		$shopCount = $_SESSION['totalCount'];
	}
	else
	{
		$shopCount = 0;
	}

	# ОБЩАЯ СТОИМОСТЬ БУКЕТОВ В КОРЗИНЕ
	if ( isset($_SESSION['totalPrice']) && $_SESSION['totalPrice'] <> 0 )
	{
		$shopSumm = $_SESSION['totalPrice'];
	}
	else
	{
		$shopSumm = 0;
	}


?>
<!DOCTYPE html>
<html>
<head>
	<title>Fleur de Lis - букеты на любой вкус!</title>

	<!-- ОБЪЯВЛЕНИЕ МЕТА-ТЕГОВ -->
	<meta charset="utf-8">

	<!-- ПОДКЛЮЧЕНИЕ СТИЛЕЙ -->
	<link rel="stylesheet" type="text/css" href="css/reset.css">
	<link rel="stylesheet" type="text/css" href="css/960_16_col.css">
	<link rel="stylesheet" type="text/css" href="css/global.css">
	<link rel="stylesheet" type="text/css" href="css/menu.css">
	<link rel="stylesheet" type="text/css" href="css/buttons.css">
	<link rel="stylesheet" type="text/css" href="css/content.css">
	<link rel="stylesheet" type="text/css" href="css/pagination.css">

	
</head>

<body>
<!-- ЦЕНТРАЛЬНЫЙ КОНТЕЙНЕР | РАЗМЕТКА ОБЛАСТИ СТРАНИЦЫ -->
<div class="container_16">
	

	<!-- "ШАПКА" САЙТА: ЛОГОТИП, НОМЕР ТЕЛЕФОНА И ГЛАВНОЕ МЕНЮ -->
	<div class="grid_16">
		<img src="images/logo.png" style="margin-bottom: 20px;">

		<span id="topText">
		Не нашли букет? Звоните<br>
		<?=getGlobalPhoneNumber();?>
		</span>

		<span id="topMenu">
			<a href="/">Главная</a>
			<a href="#">Спец. предложения</a>
			<a href="#">О нас</a>
		</span>
	</div>

	<!-- КОНТЕЙНЕР ДЛЯ ЛЕВОЙ ЧАСТИ СТРАНИЦЫ -->
	<div class="grid_4">

		<!-- БЛОК "КОРЗИНА" -->
		<div id="basketDIV">
		<span class="header">Корзина</span>
		<span class="leftMenu">
			Всего букетов: <b id="count"><?=$shopCount; ?></b>
			<u>(<a href="#" id="editBasket">редактировать список покупок</a>)</u>
			<br><br>
			Общая стоимость:<br>
			<b id="price"><?=$shopSumm; ?></b> руб.
			<br><br>
			<?php
				require('payments/form.php');
			?>
			
		</span>
		</div>

		<div id="setDIV">
		<!-- БЛОК ДЛЯ ПОДБОРА БУКЕТА ПО ПАРАМЕТРАМ -->
		<span class="header">Подбор букета</span>
		<span class="leftMenu">
			Категории:<br>
			<?=getCategoryList(); ?>
			<br>
			Стоимость:<br>
			<select id="coastSign">
				<option value=">">Больше чем</option>
				<option value="<">Меньше чем</option>
			</select>
			<input type="text" id="coastPrice" style="width: 50px" value="0"> руб.
			<br><br>
			<a href="#" class="button" id="refreshSet">Подобрать букет</a>
		</span>
		</div>
	</div>


	<!-- РОВНЯЮЩИЙ КОНТЕЙНЕР -->
	<div class="grid_12">
		

		<!-- КОНТЕЙНЕР СО СПИСКОМ ТОВАРОВ -->
		<div id="content">

			Идет загрузка списка товаров... Пожалуйста, подождите
			
		</div>

		<div id="pagination"></div>	

	</div>

</div>

<section id="basketEditList" style="display: none">
	<center>
	<div>
		<a href="#" id="closeBasket">Закрыть</a>
		<b>Список букетов в корзине:</b><br>
		<i>Если Вы хотите изменить количество букетов - нажмите на ячейку "Количество" в строке с нужным букетом</i>
		<br><br>

		<table id="editBasketTable">
						
		</table>
	</div>
	</center>
</section>

</body>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/basket.js"></script>
<script type="text/javascript" src="js/pagination.js"></script>
<script type="text/javascript" src="js/set.js"></script>


</html>