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
       // var_dump($basket);
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
    //var_dump($basket);
    $goods = array_keys($basket);
    //var_dump($goods);
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

function getOrders()//которая возвращает многомерный массив с информацией о всех заказах,
//включая персональные данные покупателя и список его товаров
{
    global $link;
    if(!is_file(ORDERS_LOG))
        return false;
         /* Получаем в виде массива персональные
 данные пользователей из файла */
    $orders = file(ORDERS_LOG);
  /* Массив, который будет возвращен функцией */
    $allorders = [];
    foreach ($orders as $order)
    {   list($name, $email, $phone, $address, $orderid, $date) = explode("|", $order);
      /* Промежуточный массив для хранения информации о конкретном заказе */
        $orderinfo = [];
         /* Сохранение информацию о конкретном пользователе */
        $orderinfo["name"] = $name;
        $orderinfo["email"] = $email;
        $orderinfo["phone"] = $phone;
        $orderinfo["address"] = $address;
        $orderinfo["orderid"] = $orderid;
        $orderinfo["date"] = $date;
          /* SQL-запрос на выборку из таблицы orders всех
           товаров для конкретного покупателя */
        $sql = "SELECT title, author, pubyear, price, quantity
             FROM orders
                 WHERE orderid = '$orderid'
                  AND datetime = $date";

                    /* Получение результата выборки */
        if(!$result = mysqli_query($link, $sql))
            return false;
        $items = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
          /* Сохранение результата в промежуточном массиве */
        $orderinfo["goods"] = $items;
         /* Добавление промежуточного массива в возвращаемый массив */
        $allorders[] = $orderinfo;
    }
    return $allorders;
}