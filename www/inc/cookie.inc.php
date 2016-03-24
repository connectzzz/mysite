<?

$visitCounter=0;

if (isset($_COOKIE['visitCounter'])){
    $visitCounter=$_COOKIE['visitCounter']+1 ;
       }else{
    $visitCounter=1;
       }

$lastVisit='';

if (isset($_COOKIE['lastVisit'])){
    $lastVisit=$_COOKIE['lastVisit'];
}

setcookie('visitCounter',$visitCounter,time()+36000);
setcookie('lastVisit',time(),time()+3600);

