<?php
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASSWORD','');
define('DB_NAME','eshop');
define('ORDERS_LOG','orders.log');
$basket=[];  // массив для хранения корзины пользователя
$count=0;    // переменная для хранения количества товаров в корзине пользователя

$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);
if (!$link){
    echo 'Ошибка подключения: '
        .mysqli_connect_errno(). ' '
        .mysqli_connect_error();
}
basketInit();

