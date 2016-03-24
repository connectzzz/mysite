<?
$dt=date('d M Y H:i:s');
$page=$_SERVER['REQUEST_URI'];
$ref=$_SERVER['HTTP_REFERER'];
$path=$dt.' | '.$page.' | '.$ref."\n";
//echo $path ;die;
file_put_contents('log/path.log',$path,FILE_APPEND);
//var_dump($_SERVER);