<!DOCTYPE html>
<html lang="ru" dir="ltr">

<head>
	<title>Laba_8</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="lab8.css">
	<meta name="description" content="Написать скрипт, 
	собирающий статистику по используемым посетителями 
	ресурса операционным системам. Выводить результаты в 
	виде HTML-таблицы со списком операционных систем, 
	отсортированным по убыванию количества пользующихся 
	ими посетителей сайта.">
</head>

<body>
	<?php

	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '7415151asd');
	define('DB_NAME', 'lab8');

	echo '<div><h2>Wellcome to this page</h2></div>';

	error_reporting(0);
	function connectToDB($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME)
	{
		$mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASSWORD, $DB_NAME);
		if ($mysqli->connect_ernno)
			exit('Ошибка соединения с БД');
		return $mysqli;
	}

	function getOSesfromDB($mysqli)
	{
		$query = "SELECT `name`, `count` FROM `OS` ORDER BY `count` DESC";
		$result = $mysqli->query($query);
		if ($result == false) {
			exit('Ошибка соединения с БД');
		}

		$os_array = [];
		while ($arr = $result->fetch_assoc()) {
			$os_array[$arr['name']] = $arr['count'];
		}

		return $os_array;
	}

	$link = connectToDB(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$os_array = getOSesfromDB($link);
	$current_os = $_SERVER['HTTP_USER_AGENT'];
	$current_os = substr($current_os, strpos($current_os, '(') + 1, strpos($current_os, ')') - strpos($current_os, '(') - 1);
	if (isset($os_array[$current_os])) {
		$os_array[$current_os]++;

		$query = "UPDATE `OS` SET `count`='" . $os_array[$current_os] . "' WHERE `name`='" . $current_os . "'";
		$result = $link->query($query);

		if ($result === false) {
			exit('Ошибка соединения с БД');
		}
	} else {
		$os_array[$current_os] = 1;
		$query = "INSERT INTO `OS`(`name`, `count`) VALUES('" . $current_os . "', '" . $os_array[$current_os] . "')";
		$result = $link->query($query);

		if ($result === false) {
			exit('Ошибка соединения с БД');
		}
	}

	$link->close();

	echo '<table class="tg" border=3><tr><th>OS name</th><th>Count</th></tr>';
	foreach ($os_array as $key => $value) {
		echo '<tr><td>' . $key . '</td><td>' . $value . '</td></tr>';
	}
	echo '</table><br><b>Current OS: ' . $current_os . '</b>';

	?>


</body>

</html>