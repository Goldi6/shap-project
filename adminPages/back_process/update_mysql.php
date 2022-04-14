<?php

$lastUpdate = rand(10000,99999);


$sql = "UPDATE users SET last_update = ? WHERE  username = ? AND id=?";
$statment = $conn->prepare($sql);

$statment->execute([
    $lastUpdate ,$_SESSION['user_name'], $_SESSION['user_id']
]);