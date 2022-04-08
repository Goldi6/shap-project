<?php

require_once '../conn.php';





$sql = 'INSERT INTO messages(shomrim, nikayon, ahzaka, stat, msg,created_by, expire_date, create_date)
 VALUES(?,?,?,?,?,?,?,?)';

$statment = $conn->prepare($sql);

$statment->execute([
    $shomrim , $nikayon, $ahzaka, 'active', $message ,$_SESSION['user_name'], $expire , $dateCreated
]);

$publisher_id = $conn->lastInsertId();


?>