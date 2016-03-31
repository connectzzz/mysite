<?php
ob_start();
	// ����������� ���������
	require "inc/lib.inc.php";
	require "inc/config.inc.php";

 $id_item=$_GET['id'];
  $basket[$id_item]=1;
//var_dump($id_item,$basket);
//echo 'klj';

add2Basket($id_item);
header("Location: catalog.php");

ob_end_clean();