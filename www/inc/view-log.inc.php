<?
if (is_file('log/path.log'))
{
    $arr=file('log/path.log');
    //var_dump($arr);die;
    echo '<ol>';
    foreach ($arr as $vel)
    {

       $res=explode('|',$vel);

       echo '<li>'. $res[0].': '.$res[1].' -> '.$res[2].'</li>' ;
    }
    echo'</ol>';
}