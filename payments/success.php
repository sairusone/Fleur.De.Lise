<?php
/**
 * Скрипт завершения операции (Success)
 * С проверкой подлинности подписи
 *
 * www.WAYtoPAY.org © 2011
 *
**/

// регистрационная информация
//id сервиса
$mrh_id       = 4886;


// HTTP параметры:
$out_summ = (float)$_REQUEST["wOutSum"];
$inv_id   = (int)$_REQUEST["wInvId"];


// Здесь вы можете добавить доп. код для большей безопасности
// Если все верено то выводим ответ

echo "Оплата заказа $inv_id прошла удачно.";

?>