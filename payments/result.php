<?php
/**
 * Скрипт получения уведомления об оплате
 * В конце проверки нужно отправить серверу ответ "OK_номер заказа"
 *
 * www.WAYtoPAY.org © 2011
 *
**/

// регистрационная информация
//id сервиса
$mrh_id         = 4886;
//Секретный ключ
$mrh_secret_key = "6720af-e1b580-bafc25-5d0353-ee95";

// HTTP параметры:
$out_summ = (float)$_REQUEST["wOutSum"];
$inv_id   = (int)$_REQUEST["wInvId"];
$is_sets  = (int)$_REQUEST["wIsTest"];
$crc      = (string)$_REQUEST["wSignature"];


// Поднимаем в верхний регистр
$crc = strtoupper($crc);

//Создаем подпись
$my_crc = strtoupper(md5("$mrh_id:$out_summ:$inv_id:$mrh_secret_key"));


//Сверяем подписи
if ($my_crc != $crc)
{
  //Если подпись не верна
  echo "ERROR_bad sign\n";
  exit();
}

// Пользовательские проверки
// К примеру сверка суммы из базы данных
// Если все верено то выводим ответ серверу

echo "OK_$inv_id";

?>