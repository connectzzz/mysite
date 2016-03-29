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
    global $count,$basket;
    if(!isset($_COOKIE['basket'])){
        $basket['orderid']=uniqid();
        saveBasket();
    }else{
        $basket=unserialize(base64_decode($_COOKIE['basket']));
        $count=count($basket)-1;
    }
}

function add2Basket($id) //которая добавляет товар в корзину пользователя
//и принимает к качестве аргумента идентификатор товара
{
    global $basket;
    $basket[$id]=1;
    saveBasket();
}

function myBasket() // которая возвращает всю пользовательскую корзину
//в виде ассоциативного массива

{
    global $link, $basket;
    $goods = array_keys($basket);
    array_shift($goods);
    if(!$goods)
        return false;
    $ids = implode(",", $goods);
    $sql = "SELECT id, author, title, pubyear, price
           FROM catalog WHERE id IN ($ids)";
    if(!$result = mysqli_query($link, $sql))
        return false;
    $items = result2Array($result);
    mysqli_free_result($result);
    return $items;
}

function result2Array($data)// которая принимает результат выполнения функции myBasket и
//возвращает ассоциативный массив товаров, дополненный их количеством
{
    global $basket; $arr = [];
    while($row = mysqli_fetch_assoc($data))
    {   $row['quantity'] = $basket[$row['id']];
        $arr[] = $row;
    }
    return $arr;

}

function deleteItemFromBasket($id)// которая удаляет товар из корзины, принимая
//в качестве аргумента его идентификатор
{
    global $basket;
    unset ($basket[$id]);
    saveBasket();
}

function saveOrder($datetime)//которая пересохраняет товары из корзины в таблицу базы
//данных orders и принимает в качестве аргумента дату и время заказа
//в виде временной метки
{
    global $link, $basket;
    $goods = myBasket();
    $stmt = mysqli_stmt_init($link);
    $sql = 'INSERT INTO orders (
                       title,
                       author,
                       pubyear,
                       price,
                       quantity,
                       orderid,
                       datetime)
        VALUES (?, ?, ?, ?, ?, ?, ?)';
    if (!mysqli_stmt_prepare($stmt, $sql))
        return false;
    foreach($goods as $item)
    {   mysqli_stmt_bind_param($stmt, "ssiiisi",
        $item['title'], $item['author'],
        $item['pubyear'], $item['price'],
        $item['quantity'], $basket['orderid'],
        $datetime);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
    setcookie('basket',$basket['orderid'],-1000);
    return true;

}