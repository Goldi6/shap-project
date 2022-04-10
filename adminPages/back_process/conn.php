<?php


require_once 'credentials.php';


try{
  $conn = new PDO("mysql:host=$server;dbname=$dbName",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
 $er= 'Connection failed : '.$e->getMessage();
    $msg = 'Can\'t connect to the server, please again try later';
    $loc = $url.'?connerror=' . $msg;
 
     header('Location:'.$loc);
}