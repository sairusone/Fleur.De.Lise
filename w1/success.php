<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	# ОПРЕДЕЛЕНИЕ ГЛОБАЛЬНЫХ ПЕРЕМЕННЫХ
	require("../classes/define.class.php");

	$order_id		= $_POST['WMI_PAYMENT_NO'];
	$order_type		= $_POST['WMI_PAYMENT_TYPE'];
	$status			= $_POST['WMI_ORDER_STATE'];
	$wmi_id			= $_POST['WMI_ORDER_ID'];
		
	db::dbQuery("UPDATE `orders` SET `order_status`='$status', `order_type`='$order_type', `wmi_id`='$wmi_id' WHERE `order_id` = '$order_id'", false, false);

	echo "WMI_RESULT=OK&WMI_DESCRIPTION=Заказ успешно оплачен!";
} else {
	echo "WMI_RESULT=RETRY&WMI_DESCRIPTION=Ошибка при оплате!";
}

?>