<?php

function addItemToCatalog($title,$author,$pubyear,$price)
{
    $sql='INSERT INTO eshop (title,author,pubyear,price) VALUES (?,?,?,?)';

    if (!$stmt=mysqli_prepare($link,$sql)){
        return false;
    }
    mysqli_stmt_bind_param($stmt,'ssii',$title,$author,$pubyear,$price);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}