<?php
$basket=[];
function basketInit() //создает или загружает в переменную $basket корзину с товарами
    // , либо создает новую корзину с идентификатором заказа

{
    global $basket;

   // $basket[]=20;
   if(isset($_COOKIE['basket'])){
        $basket=['orderid'=>uniqid()];
        //saveBasket();
    }else{
        $basket=unserialize(base64_decode($_COOKIE['basket']));
        $count=count($basket)-1;
    }

}
basketInit();
var_dump($basket);