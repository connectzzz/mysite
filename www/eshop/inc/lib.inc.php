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
    $basket=base64_decode(serialize($basket));
    setcookie('basket',$basket,0x7FFFFFFF);
}

function basketInit() //создает или загружает в переменную $basket корзину с товарами
    // , либо создает новую корзину с идентификатором заказа

{
    global $count,$basket;
    if(isset($_COOKIE['basket'])){
        $basket=['orderid'=>uniqid()];
        saveBasket();
    }else{
        $basket=unserialize(base64_decode($_COOKIE['basket']));
        $count=count($basket)-1;
    }
}