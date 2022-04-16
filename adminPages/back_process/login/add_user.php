<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && ($_SESSION['user_status']) === 1) {

    function strip($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      
    } 



    $url = $_POST['url'];
    $errors=[];
        
    $password = isset($_POST['password'])? strip($_POST['password']):array_push($errors,'* need a password');
    $password_repeat = isset($_POST['password_repeat'])?strip($_POST['password_repeat']):array_push($errors,'* need a password repeat');

    $username = isset($_POST['username'])? strip($_POST['username']):array_push($errors,'* username is missing');

    $status = isset($_POST['status'])? strip($_POST['status']):array_push($errors,'* select status');

    $email = isset($_POST['email'])? strip($_POST['email']):'';


    $regex = preg_match('/^[A-Za-z0-9]*$/' , $username);
    if ($regex!==1){
        array_push($errors,'* username can contain only alphanumeric values');

    }

    if($password === $password_repeat){

        if(!empty($email)){
            $regex = preg_match("/^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/", $email);
            if($regex !== 1){
                array_push($errors,'* invalid email');
            }
        }
    }else{
        array_push($errors,'* passwords don\'t match');

    }


    if(sizeof($errors) ===0){

    
        require_once '../conn.php';


        $query = 'INSERT INTO users(username,password,status,email) VALUES(?,?,?,?)';

        $stmt = $conn->prepare($query);
        $stmt->execute($username , $password,$status,$email);

        echo 'success! user added!';

        $conn=null;
    }else{
        $err = '?error=' . join('<br>',$errors);
        echo $err;
    }

}else{
    echo 'not allowed to add users';
}


?>