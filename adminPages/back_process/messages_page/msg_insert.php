<?php

require_once '../conn.php';





$sql = 'INSERT INTO messages(shomrim, nikayon, ahzaka, stat, msg, expire_date, create_date)
 VALUES(?,?,?,?,?,?,?)';

$statment = $conn->prepare($sql);

$statment->execute([
    $shomrim , $nikayon, $ahzaka, 'active', $message , $expire , $dateCreated
]);

$publisher_id = $conn->lastInsertId();


?>