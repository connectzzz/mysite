<?php
	require "inc/lib.inc.php";
	require "inc/config.inc.php";


$name=$_POST['name'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$address=$_POST['address'];

$orderid=$basket['orderid'];
$time=time();

$order=$name.'|'.$email.'|'.$phone.'|'.$address.'|'.$orderid.'|'.$time."\n";

/*$f=fopen(,'a+');
fputs($f,$order);
fclose($f);*/
$path='admin/'.ORDERS_LOG;
file_put_contents($path, $order, FILE_APPEND);





?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Сохранение данных заказа</title>
</head>
<body>
<?php


?>
	<p>Ваш заказ принят.</p>
	<p><a href="catalog.php">Вернуться в каталог товаров</a></p>
</body>
</html>