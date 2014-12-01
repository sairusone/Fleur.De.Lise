<?php
/**
 * Скрипт иницаиализации платежа
 * Формирование платежа
 *
 * www.WAYtoPAY.org © 2011
 *
**/


// регистрационная информация
//id сервиса
$mrh_id       = 4886;

// номер заказа
$inv_id = 1;

// описание заказа
$inv_desc = "Демонстрационный заказ на WAY to PAY";

// сумма заказа
$out_summ = "10.23";

// предлагаемая валюта платежа
// default - 1 - WMR
$in_curr = "1";


// форма оплаты товара
// payment form
print
   "<form action='https://waytopay.org/merchant/index' method=POST>".
   "<input type=hidden name=MerchantId value=$mrh_id>".
   "<input type=hidden name=OutSum value=$out_summ>".
   "<input type=hidden name=InvId value=$inv_id>".
   "<input type=hidden name=InvDesc value='$inv_desc'>".
   "<input type=hidden name=IncCurr value=$in_curr>".
   '<a href="#" class="button" id="payment">Оформить покупку</a>'.
   "<input type=submit value='Купить' style='display:none' id='waytopay'>".
   "</form>";

   echo str_shuffle(time());

?>