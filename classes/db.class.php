<?php

############################################################
############################################################
###
### КЛАСС РАБОТЫ С БАЗОЙ ДАННЫХ
### --------------------------------------------------------
### Поддержка AJAX: НЕТ
###
############################################################
############################################################

class db
{

# ВНУТРИКЛАССОВАЯ ССЫЛКА НА СОЕДИНЕНИЕ С БАЗОЙ ДАННЫХ
protected static $connect;



# СОЕДИНЕНИЕ С БАЗОЙ ДАННЫХ
protected static function dbConnect()
{
	$host = "localhost";
	$username = "root";
	$password = "";

	$database = "u985467612_fdl";

	self::$connect = mysql_connect($host, $username, $password);
	mysql_select_db($database, self::$connect);

	mysql_query("SET NAMES utf8", self::$connect);
}

# РАЗЪЕДИНЕНИЕ С БАЗОЙ ДАННЫХ
protected static function dbDisconnect()
{
	mysql_close(self::$connect);
}



# ЗАПРОС К БАЗЕ ДАННЫХ
public static function dbQuery( $queryString, $fetchFunction = True, $RES = True)
{
	# ПОДКЛЮЧАЕМСЯ К БД
	self::dbConnect();

	# НАПРАВЛЯЕМ ЗАПРОС В БАЗУ ДАННЫХ ПОСЛЕ ПРОВЕРКИ НА ВЫПОЛНЕНИЕ REAL_ESCAPE_STRING (ДЛЯ ЗАПРОСОВ ПОДБОРКИ ЕГО ИСПОЛЬЗОВАНИЕ ПРИВЕДЕТ К НЕВОЗМОЖНОСТИ ВЫБОРКИ)
	if ( $RES == True )
	{
		$dbQuery = mysql_query( mysql_real_escape_string($queryString), self::$connect) or die(mysql_error());
	}
	else
	{
		$dbQuery = mysql_query($queryString, self::$connect) or die(mysql_error());
	}

	

	# ЕСЛИ ТРЕБУЕТСЯ ВЕРНУТЬ МАССИВ С РЕЗУЛЬТАТАМИ - ОБРАБАТЫВАЕМ
	if ( $fetchFunction == True )
	{
		$dbQuery = mysql_fetch_array( $dbQuery );
	}

	# ОТКЛЮЧАЕМСЯ ОТ БД
	self::dbDisconnect();

	# ВОЗВРАЩАЕМ ЗНАЧЕНИЕ
	return $dbQuery;
}

}