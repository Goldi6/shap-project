<?php



require_once '../conn.php';

$random = rand(100000,999999);


$sql = 'INSERT INTO messages(shomrim, nikayon, ahzaka, stat, msg,created_by, expire_date, create_date, random_id)
 VALUES(?,?,?,?,?,?,?,?,?)';

$statment = $conn->prepare($sql);

$statment->execute([
    $shomrim , $nikayon, $ahzaka, 'active', $message ,$_SESSION['user_name'], $expire , $dateCreated , $random
]);

//$publisher_id = $conn->lastInsertId();

include_once '../update_mysql.php';
?>