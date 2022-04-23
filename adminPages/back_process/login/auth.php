<?php
session_start();
require_once '../conn.php';

$url = $_POST['url'];
if(!isset($er)){

    function strip($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      
    } 



if(isset($_POST['username']) && isset($_POST['password'])){
    $userName = strip($_POST['username']);
    $password = strip($_POST['password']);


    if(empty($userName)){
        header("Location: ../../Login.php?error=Username is required *");
    }elseif(empty($password)){
        header("Location: ../../Login.php?error=Password is required *");

    }else{
    
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE Username=?");
        $stmt->execute([$userName]);

        if($stmt->rowCount()===1){
             
            $user = $stmt->fetch();
            $user_id = $user['id'];
            $user_name = $user['username'];
            $user_email = $user['email'];
            $user_status = $user['status'];
            $user_password = $user['password'];

           // print_r($user);
            if($userName === $user_name){
                if(password_verify($password , $user_password) && ($user_status>0 && $user_status<3)){
                    
                    $_SESSION['user_id'] =$user_id;
                    $_SESSION['user_name'] = $user_name;
                    $_SESSION['user_email'] = $user_email;
                    $_SESSION['user_status'] = $user_status;
                    header("Location: ../../pages/CreateMsg.php");

                }
            }else{
                header("Location: ../../Login.php?error=Incorrect username or password *");

            }
        }else{
            header("Location: ../../Login.php?error=Incorrect username or password *");

        }
    }

}
}
?>