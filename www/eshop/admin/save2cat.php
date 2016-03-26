<?php
	// подключение библиотек
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/config.inc.php";

ob_start();
if ($_POST['title']&&$_POST['author']&&$_POST['pubyear']&&$_POST['price'])
{
    $title=$_POST['title'];
    $author=$_POST['author'];
    $pubyear=$_POST['pubyear'];
    $price=$_POST['price'];

    if(!addItemToCatalog($title,$author,$pubyear,$price,$link))
    {
        echo 'Произошла ошибка при добавлении товара в коталог';
    }else{
       header("Location: add2cat.php");
       // var_dump($link);
        //echo $title.'<br>'.$pubyear.'<br>'.$author.'<br>'.$price;
       exit;
    }
}else {
    header("Location: add2cat.php");//не реализованно


}

ob_end_flush();