<?php
require_once '../../adminPages/back_process/conn.php';

$query = "SELECT msg FROM messages WHERE ". $section ."=1 AND stat='active'";

$stmt = $conn->prepare($query);
  $stmt->execute();

 
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo   $row['msg'] ;
    }

$conn = null;