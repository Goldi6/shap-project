<?php
session_start();


$url = $_POST['url'];
$errors=[];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

    $id = isset($_POST['id']) ? $_POST['id'] : array_push($errors,'<br> not message id received<br> ');
    $date = isset($_POST['original_date']) ? $_POST['original_date'] : array_push($errors,' <br>something\'s wrong with the data <br>');

    $del = isset($_POST['delete']) && $_POST['delete']==1 ? true:false; 

    if($del && empty($errors)){
        require_once '../conn.php';

        $query = "DELETE FROM messages WHERE random_id= ? AND create_date= ? ";
        $stmt = $conn->prepare($query);
        $stmt->execute([$id , $date]);
        echo "deleted";
    }else{

        echo "incorrect value or " . json_encode($errors);
    }

}