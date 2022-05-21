<?php
//??? SEND verification TOKEN to user EMail??
session_start();

$errors=[];

function strip($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    
} 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
    $url = explode("?",$_POST['url']);
    $url = $url[0];

    $original_pass = isset($_POST['old-pass'])?$_POST['old-pass']:array_push($errors,'please type you current password');
    $new_pass = isset($_POST['new-pass'])?$_POST['new-pass']:array_push($errors,'please type a new password');
    $retype_new_pass = isset($_POST['retype-new-pass'])?$_POST['retype-new-pass']:array_push($errors,'please retype the new password');

    $passTrue = $new_pass === $retype_new_pass? $new_pass: array_push($errors,"* passwords don't match"); 
    $diff = $passTrue !== $original_pass? true:array_push($errors,"* you can't set the same password!");

    if(empty($errors) && $diff){

        require_once '../conn.php';

        $query = "SELECT * FROM users WHERE id=? AND username=? ";
        $stmt = $conn->prepare($query);
        
        $stmt->execute([$_SESSION['user_id'], $_SESSION['user_name']]);

        if($stmt->rowCount()===1){
                
            $user = $stmt->fetch();
            
                if(password_verify($original_pass , $user['password'])){
                    $query = "UPDATE users SET password=? WHERE id=? AND username=?";
                    try{

                        $stmt = $conn->prepare($query)->execute([password_hash($passTrue,PASSWORD_DEFAULT, $options), $_SESSION['user_id'], $_SESSION['user_name']]);
                        echo 'success';
                        $_SESSION['message_success'] = rand(1000,9999);
                        header("Location:" . $url."?success=* password Updated!");

                    }catch(PDOException $e){
                        echo $e;
                        $_SESSION['message_success'] = rand(1000,9999);

                        header("Location:" . $url."?changePasswordError=* something is wrong with the query");
                    }
                }else{
                    echo 'fail';
                    header("Location:" . $url."?changePasswordError=* your password is incorrect, please try again.");
                }

        }else{
            header("Location:" . $url."?changePasswordError=* something is wrong with the query");

        }
    }else{
       
        print_r($errors);
        header("Location:" . $url."?changePasswordError=* you already have this password set");

    }
        
}
$conn = null;
die();