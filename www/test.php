<?php
echo '<pre>';


$link=mysqli_connect('localhost','root','','web');

if(!$link){
    echo 'oshibka'
    .mysqli_connect_errno(). ':'
    .mysqli_connect_error();
}

mysqli_select_db($link,'test');
mysqli_close($link);
//--------------------
$link=mysqli_connect('localhost','root','','web');

$result=mysqli_query($link,"select * from teachers");
var_dump($result);
if(!$result)
{
    echo 'oshibka'
    .mysqli_errno($link).': '
    .mysqli_error($link);
}
//var_dump($link);

//$row = mysqli_fetch_array($result,MYSQL_NUM);
//$row=mysqli_fetch_assoc($result);
//$row=mysqli_fetch_row($result);
$row=mysqli_fetch_all($result);

var_dump($row);
mysqli_close($link);
//-----------------------

$link=mysqli_connect('localhost','root','','web');
$name=mysqli_real_escape_string($link,"John O'Brain");
$sql="INSERT INTO teachers (name) VALUES ('$name')";
echo $sql;
//var_dump(mysqli_character_set_name($link));
$quer=mysqli_query($link,$sql);
echo 'инсерт квери <br>';
var_dump($quer);
$count=mysqli_insert_id($link);
var_dump($count);
$sql="DELETE FROM teachers WHERE id=0";
mysqli_query($link,$sql);
$count=mysqli_affected_rows($link);
var_dump($count);

$sql="SELECT * from teachers";
$result=mysqli_query($link,$sql);

$row_count=mysqli_num_rows($result);
$field_count=mysqli_num_fields($result);
echo '<br> zapisi: '.$row_count.'<br> polja: '.$field_count;


































/*
//$pas=crypt('password');

$hash= password_hash('password',PASSWORD_BCRYPT,['salt'=>'klkli9dsfsd9knjkjlkjkljlknjk','cost'=>10]);

var_dump(password_verify('password',$hash));

print_r(password_get_info($hash));

var_dump(password_needs_rehash($hash,PASSWORD_BCRYPT,['cost'=>10]));





echo $pas;
echo $hash;




/*
$timeTarget = .5; // 50 milliseconds

$cost = 10;
do {
    $cost++;
    $start = microtime(true);
    password_hash("test", PASSWORD_BCRYPT, ["cost" => $cost]);
    $end = microtime(true);
} while (($end - $start) < $timeTarget);

echo "Appropriate Cost Found: " . $cost . "\n";





//----------------------------------------------------------
// Открываем словарь CrackLib
$dictionary = crack_opendict('/usr/local/lib/pw_dict')
or die('Unable to open CrackLib dictionary');

// Выполняем проверку пароля
$check = crack_check($dictionary, 'gx9A2s0x');

// Получаем сообщения
$diag = crack_getlastmessage();
echo $diag; // 'strong password'

// Закрываем словарь
crack_closedict($dictionary);






































/*
//mkdir('test/0');
//rmdir('test/new/bar');

ob_start();
echo '<pre>';

echo getcwd();
//chdir('test');
echo '<br>'.getcwd();
//chroot('/');
echo '<br>';//.getcwd();
var_dump(dir('test'));
copy('test/q1.php','test/new/qqq.php');
rename('test/new/qqq.php','test/0/q111.php');
unlink('test/0/q111.php');

?>
<form action="" metod="post" enctype="multipart/form-data">
    <input type="text" name="d">
    <input type="hidden" name="MAX_FILE_SIZE" value="4096">
    <input type="file" name="file">
    <input type="submit" name="file">

</form>

<?php

$f=ob_get_flush();
echo 'okzdfokdskf';

echo $f;
*/