<?php

//creates test admin user

require_once '../adminPages/back_process/credentials.php';

try{
    $conn = new PDO("mysql:host=$server;dbname=$dbName",$username,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $options =  ['cost' => 12];
  
  }catch(PDOException $e){
   $er= 'Connection failed : '.$e->getMessage();
      $msg = 'Can\'t connect to the server, please try again later';
  
     echo $msg;
  }


$query = 'INSERT INTO users(username, email, status, password, email_verified) VALUES(?,?,?,?,?)';
$stmt = $conn->prepare($query);
$username = 'admin';
$password = 'admin';
try{
    $stmt->execute([$username,'admin@admin.com',1,password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]),1]);
    echo 'user Created!';
    echo '<br>username: '. $username . "<br>password: " . $password;
}catch(PDOException $e){
    echo $e;
}

?>