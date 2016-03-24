<?php
/* Основные настройки */
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASSWORD','');
define('DB_NAME','gbook');
$link=mysqli_connect(DB_HOST,DB_LOGIN,DB_PASSWORD,DB_NAME);
/* Основные настройки */

/* Сохранение записи в БД */
if($_POST['name'] && $_POST['email']){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $msg=$_POST['msg'];
    //$sql='INSERT INTO msgs (name,email,msg) VALUES ('.$name.','.$email.','.$msg.')';
    $sql="INSERT INTO msgs (name, email, msg) VALUES  ('$name','$email','$msg')";
    //echo $sql;
    $qur=mysqli_query($link,$sql);
    echo mysqli_insert_id($link);



}
/* Сохранение записи в БД */

/* Удаление записи из БД */
if($_GET['id']==='gbook'){
    $sql="DELETE from msgs WHERE id=".$_GET['del'];
    mysqli_query($link,$sql);
}

/* Удаление записи из БД */
?>
<h3>Оставьте запись в нашей Гостевой книге</h3>

<form method="post" action="<?= $_SERVER['REQUEST_URI']?>">
Имя: <br /><input type="text" name="name" /><br />
Email: <br /><input type="text" name="email" /><br />
Сообщение: <br /><textarea name="msg"></textarea><br />

<br />

<input type="submit" value="Отправить!" />

</form>
<?php
/* Вывод записей из БД */
$sql="SELECT id,name,email,msg,UNIX_TIMESTAMP(datetime) as dt
       FROM msgs
       ORDER BY id DESC";
$res=mysqli_query($link,$sql);
mysqli_close($link);

/* Вывод записей из БД */
?>
<p>Всего записей в гостевой книге:<?php echo mysqli_num_rows($res); ?> </p>
<?php while ($row=mysqli_fetch_row($res)):
    list($id,$name,$email,$msg,$dt)=$row;
   // var_dump($row);

    ?>
<p>
    <a href="mailto:<?php echo $email; ?>"> <?php echo $name; ?></a>
    <?php echo date("Y-m-d H:i:s",$dt); ?> написал: <br><?php echo $msg; ?>
</p>
<p align="right">
    <a href="<?php echo 'http://mysite.local/index.php?id=gbook&del='.$id ?>">Удалить</a>
</p>
<?php endwhile;

$a=['jksjda','skdfo'];
list($s,$b)=$a;
var_dump($s,$b,$a);