<?php
//[ ] configure on host;
$homeUrl = 'http://localhost/websites/shapProject/mainWebsite/index.php';
$url = isset($_POST['url'])? isset($_POST['url']): $homeUrl;  


require_once '../../adminPages/back_process/conn.php';


$result =0;

$query = false;

if($query){
    $result = 1;
}






echo $result;