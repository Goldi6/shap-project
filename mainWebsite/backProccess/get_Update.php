<?php
//[ ] configure on host;
$homeUrl = 'http://localhost/websites/shapProject/mainWebsite/index.php';
$url = isset($_POST['url'])? isset($_POST['url']): $homeUrl;  


require_once '../../adminPages/back_process/conn.php';




$query = 'SELECT last_update FROM users
WHERE date_of_last_update IN (SELECT max(date_of_last_update) FROM users)';
//'SELECT TOP 1 last_update FROM users ORDER BY date_of_last_update DESC'
$stmt = $conn->prepare($query);
        $stmt->execute();

        if($stmt->rowCount()===1){
             
            $user = $stmt->fetch();
            $updateId = $user['last_update'];
        }








echo $updateId;