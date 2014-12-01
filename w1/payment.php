<?php


session_start();


# ОПРЕДЕЛЕНИЕ ГЛОБАЛЬНЫХ ПЕРЕМЕННЫХ
require("../classes/define.class.php");


require("../classes/static_information.class.php");
//require("../classes/products.class.php");


?>

<!DOCTYPE html>
<html>
<head>
	<title>Fleur de Lis - букеты на любой вкус!</title>

	<!-- ОБЪЯВЛЕНИЕ МЕТА-ТЕГОВ -->
	<meta charset="utf-8">

	<!-- ПОДКЛЮЧЕНИЕ СТИЛЕЙ -->
	<link rel="stylesheet" type="text/css" href="../css/reset.css">
	<link rel="stylesheet" type="text/css" href="../css/960_16_col.css">
	<link rel="stylesheet" type="text/css" href="../css/global.css">
	<link rel="stylesheet" type="text/css" href="../css/menu.css">
	<link rel="stylesheet" type="text/css" href="../css/buttons.css">
	<link rel="stylesheet" type="text/css" href="../css/content.css">
	<link rel="stylesheet" type="text/css" href="../css/pagination.css">

	
</head>

<body>

<!-- ЦЕНТРАЛЬНЫЙ КОНТЕЙНЕР | РАЗМЕТКА ОБЛАСТИ СТРАНИЦЫ -->
<div class="container_16">
	

	<!-- "ШАПКА" САЙТА: ЛОГОТИП, НОМЕР ТЕЛЕФОНА И ГЛАВНОЕ МЕНЮ -->
	<div class="grid_16">
		<img src="../images/logo.png" style="margin-bottom: 20px;">

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



	<div class="grid_16">

	<center>

	
	<form action="payment.php" method="POST" name="frm">
			
		
	<span class="header paymentHeader">Оформление оплаты</span>
	<div class="payment">


	<?php

	$isRight = false;

	if (isset($_POST['payButton'])) {
		//echo "string1";

		if ( !empty($_POST['firstname'])	&&
			 !empty($_POST['lastname'])		&&
			 !empty($_POST['middlename'])	&&
			 !empty($_POST['address'])		&&
			 !empty($_POST['phone'])		)
		{
			
			$isRight = true;

		} else {

			echo "<span style='color:red; text-shadow: 0 1px 0px black'>Корректно заполнены не все поля.<br>Заполните все поля и повторите попытку</span>";

			echo "<br><br><br>";
			$isRight = false;

		}

	}

	?>


	<table>
	<tr>	<td>Фамилия:</td>			<td><input type="text" name="firstname"></td>	</tr>
	<tr>	<td>Имя:</td>				<td><input type="text" name="lastname"></td>	</tr>
	<tr>	<td>Отчество:</td>			<td><input type="text" name="middlename"></td>	</tr>
	
	<tr><td> <br> </td><td> <br> </td></tr>
	
	<tr>	<td>Адрес доставки:</td>	<td><input type="text" name="address"></td>	</tr>
	
	<tr><td> <br> </td><td> <br> </td></tr>
	
	<tr>	<td>Номер телефона:</td>	<td><input type="text" name="phone"></td>	</tr>

	<tr><td> <br> </td><td> <br> </td></tr>
	
	<tr>	<td>Примечания:</td>	<td><input type="text" name="desc"></td>	</tr>

	<tr><td> <br> </td><td> <br> </td></tr>
	<tr><td> <br> </td><td> <br> </td></tr>
	
	<tr>	<td>Всего букетов:</td>		<td><strong><?=$_SESSION['totalCount']?> шт.</strong></td>	</tr>
	<tr>	<td>Общая стоимость:</td>		<td><strong><?=$_SESSION['totalPrice']?> руб.</strong></td>	</tr>
	</table>

	<br><br>

	*** Внимательно заполняйте все поля! После <br>оплаты изменение данных будет невозможно!

	<br><br>

<?php


//print_r($_SESSION);

//echo "<br>";

?>

<input type="submit" class='button' name="payButton" value="Перейти к оплате" />
</form>

</div>

</center>


</div>

</div>

<?php

if ($isRight == true) {
	//Секретный ключ интернет-магазина
$key = "UW85XHt0TlleYHlHfFVfdkExUDkyMXVBSTVy";

$fields = array(); 

// Добавление полей формы в ассоциативный массив
$fields["WMI_MERCHANT_ID"]    = "157846159271";
$fields["WMI_PAYMENT_AMOUNT"] = $_SESSION['totalPrice'];
$fields["WMI_CURRENCY_ID"]    = "643";

$order_identifier = time() . "-" . rand(000,999);

$fields["WMI_PAYMENT_NO"]     = $order_identifier;
$fields["WMI_ORDER_ID"]       = $order_identifier;
$fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode("Оплата покупки #" . $fields["WMI_PAYMENT_NO"] . " в магазине Fleur de Lis");
$fields["WMI_EXPIRED_DATE"]   = "2019-12-31T23:59:59";
$fields["WMI_SUCCESS_URL"]    = "https://www.fleurdelis-shop.tk/w1/success.php";
$fields["WMI_FAIL_URL"]       = "https://www.fleurdelis-shop.tk/w1/fail.php";
//$fields["MyShopParam1"]       = "Value1"; // Дополнительные параметры
//$fields["MyShopParam2"]       = "Value2"; // интернет-магазина тоже участвуют
//$fields["MyShopParam3"]       = "Value3"; // при формировании подписи!
//Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
//$fields["WMI_PTENABLED"]      = array("ContactRUB", "UnistreamRUB", "SberbankRUB", "RussianPostRUB");

//Сортировка значений внутри полей
foreach($fields as $name => $val) 
{
  if (is_array($val))
  {
     usort($val, "strcasecmp");
     $fields[$name] = $val;
  }
}


// Формирование сообщения, путем объединения значений формы, 
// отсортированных по именам ключей в порядке возрастания.
uksort($fields, "strcasecmp");
$fieldValues = "";

foreach($fields as $value) 
{
    if (is_array($value))
       foreach($value as $v)
       {
      //Конвертация из текущей кодировки (UTF-8)
          //необходима только если кодировка магазина отлична от Windows-1251
          $v = iconv("utf-8", "windows-1251", $v);
          $fieldValues .= $v;
       }
   else
  {
     //Конвертация из текущей кодировки (UTF-8)
     //необходима только если кодировка магазина отлична от Windows-1251
     $value = iconv("utf-8", "windows-1251", $value);
     $fieldValues .= $value;
  }
}

// Формирование значения параметра WMI_SIGNATURE, путем 
// вычисления отпечатка, сформированного выше сообщения, 
// по алгоритму MD5 и представление его в Base64

$signature = base64_encode(pack("H*", md5($fieldValues . $key)));

//Добавление параметра WMI_SIGNATURE в словарь параметров формы

$fields["WMI_SIGNATURE"] = $signature;

// Формирование HTML-кода платежной формы

print "<form action=\"https://merchant.w1.ru/checkout/default.aspx\" method=\"POST\" id='frm'>";

foreach($fields as $key => $val)
{
    if (is_array($val))
       foreach($val as $value)
       {
     print "<input type=\"hidden\" name=\"$key\" value=\"$value\"/>";
       }
    else	    
       print "<input type=\"hidden\" name=\"$key\" value=\"$val\"/>";
}

$prod = "";
foreach ($_SESSION['productsList'] as $key => $value) {
	for ($i=0; $i < $value; $i++) { 
		$prod .= $key . ',';
	}
}
$prod = substr($prod, 0, strlen($prod)-1);

$firstname		= htmlentities($_POST['firstname']);
$lastname		= htmlentities($_POST['lastname']);
$middlename		= htmlentities($_POST['middlename']);
$phone 			= htmlentities($_POST['phone']);
$address		= htmlentities($_POST['address']);
$desc 			= htmlentities($_POST['desc']);
$order_id 		= $order_identifier;


db::dbQuery("INSERT INTO `orders` (`products`, `firstname`, `lastname`, `middlename`, `phone`, `address`, `order_id`, `description`) VALUES ('$prod','$firstname','$lastname','$middlename','$phone','$address','$order_id','$desc')",false,false);

print "<input type=\"submit\" style='display:none'/></form>";
?>

	<script language="JavaScript">

		document.forms['frm'].submit();

	
	</script>

	<?php
}



?>
