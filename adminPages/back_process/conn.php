<?php


require_once 'credentials.php';


try{
  $conn = new PDO("mysql:host=$server;dbname=$dbName",$username,$password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo('Connection failed : '.$e->getMessage());
}