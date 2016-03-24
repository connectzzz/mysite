<?php
var_dump($_POST['submit']);
var_dump($_FILES['f_image']['tmp_name']);
if ($_POST['submit']&&$_FILES['f_image']['tmp_name']){
    var_dump( getimagesize($_FILES['f_image']['tmp_name']));





}

?>

<form  action="form.php"  method="post" enctype="multipart/form-data">
    <input type="hidden" name="MAX_FILE_SIZE" value="300000">
    <input type="file" name="f_image">
    <input type="submit" name="submit">
</form>