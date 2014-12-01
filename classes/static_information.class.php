<?php

############################################################
############################################################
###
### КЛАСС ВЫВОДА ТОВАРОВ
### --------------------------------------------------------
### Поддержка AJAX: НЕТ
###
############################################################
############################################################

# ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ
require_once(ROOT_SERVER . '/classes/db.class.php');

# ЗАПРОС НОМЕРА ТЕЛЕФОНА ФИРМЫ
function getGlobalPhoneNumber()
{
	$phoneNum = db::dbQuery("SELECT `phone_prefix`, `phone_number` FROM `settings`");
	return '+7 (' . $phoneNum['phone_prefix'] . ') <b>' . $phoneNum['phone_number'] . '</b>';
}

function getCategoryList()
{
	$allCategories = db::dbQuery('SELECT * FROM `categories`', False);

	while ( $category = mysql_fetch_array($allCategories) )
	{
		echo '<input type="checkbox" class="setCategory" id="' . $category['id'] . '" />' . $category['name'] . '<br>';
	}
}
