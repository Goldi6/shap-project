<?php


require_once 'credentials.php';


try{
  $conn = new PDO("mysql:host=$server;dbname=$dbName",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $options =  ['cost' => 12];

}catch(PDOException $e){
 $er= 'Connection failed : '.$e->getMessage();
    $msg = 'Can\'t connect to the server, please try again later';

    $loc = $_SERVER['HTTP_HOST'] .$url.'?connerror=' . $msg;
 
     header('Location:'.$loc);
}