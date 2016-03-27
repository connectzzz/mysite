<?php

function addItemToCatalog($title,$author,$pubyear,$price,$link)
{
    $sql='INSERT INTO catalog  (title,author,pubyear,price) VALUES (?,?,?,?)';

    if (!$stmt=mysqli_prepare($link,$sql)){
        return false;
    }
    mysqli_stmt_bind_param($stmt,'ssii',$title,$author,$pubyear,$price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

function selectAllItems($link)
{
    $sql='SELECT id,title,author,pubyear,price FROM catalog';

    if(!$result=mysqli_query($link,$sql))
    {
        return false;
    }
    $items=mysqli_fetch_all($result,MYSQLI_ASSOC);
    mysqli_free_result($result);
    return $items;
}

function saveBasket() // сохраняет корзину с товарами в куки
{
    global $basket;
    $basket=base64_encode(serialize($basket));
    setcookie('basket',$basket,0x7FFFFFFF);
}

function basketInit() //создает или загружает в переменную $basket корзину с товарами
    // , либо создает новую корзину с идентификатором заказа

{
    global $count,$basket,$too;
    if(!isset($_COOKIE['basket'])){
        $basket['orderid']=uniqid();
        saveBasket();
        $too=true;
    }else{
        $basket=unserialize(base64_decode($_COOKIE['basket']));
        $count=count($basket)-1;
        $too=false;
    }
}

function add2Basket($id) //которая добавляет товар в корзину пользователя
//и принимает к качестве аргумента идентификатор товара
{
    global $basket;
    $basket[$id]=1;
    saveBasket();
}
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

$aa=$basket;
basketInit();
$coo=$_COOKIE['basket'];
var_dump($basket);
echo '<br>';
var_dump($count);
echo '<br> ';
var_dump($aa);
var_dump(unserialize(base64_decode($coo)));
echo $too;