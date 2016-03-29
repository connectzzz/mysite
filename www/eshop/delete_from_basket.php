<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

$id_del=$_GET['id'];
deleteItemFromBasket($id_del);
header("Location: basket.php");
exit;
