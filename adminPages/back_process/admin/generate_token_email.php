<?php 

session_start();
require_once 'clearEmail_func.php';

$data = [];

if(isset($_POST['setEmail']) && isset($_POST['againEmail'])){
    $temp_email = clearEmail($_POST['setEmail']);
    $again_email = clearEmail($_POST['againEmail']);

    $url = $_POST['url'];

    if($temp_email === $again_email && $_SESSION['user_email']!=$temp_email){

        //check for duplicates
        require_once '../conn.php';
        $sql = 'SELECT * FROM users WHERE email=?';
        $stmt = $conn->prepare($sql);
        $stmt->execute([$temp_email]);
        if($stmt->rowCount()>0){
            $data['error'] = '* this email is used by someone';
            $data['result']='fail';        
        }else{

        
        $data['temp_email'] = $temp_email;

        ///////////////
        $minutes_to_add = 15;

        $time = new DateTime("now",new DateTimeZone('Asia/Jerusalem'));
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        
        $stamp = $time->format('Y-m-d H:i:s');

        $data['stamp'] = $stamp;
        ////////////////////////
        $token = rand(100000 , 999999);


        $sql =  'INSERT INTO tokens(user_id,token,email_password,temp_value,expiry_time) VALUES(?,?,?,?,?)';
        $stmt = $conn->prepare($sql);

        try{
            $stmt->execute([$_SESSION['user_id'],password_hash($token,PASSWORD_DEFAULT),'email',$temp_email,$stamp]);
            $token_get_id = $conn->lastInsertId();
            //set session to prevent second token 
            $randToken = rand(1000,9999);
            $_SESSION['email_token'] = $temp_email; $_SESSION['email_token_exp'] = $stamp; $_SESSION['email_token_rand'] = $randToken;
            $_SESSION['email_token_id'] = $token_get_id;
            $data['email_token'] = $randToken;

            $data['result'] = 'generated';
            //TODO:
            //send email with $token

        }catch(PDOException $e){
            echo $e;
            $data['error'] = '* error generating token';
            $data['result']='fail';
        }
      }
    }elseif($_SESSION['user_email']===$temp_email){
        $data['result'] = 'fail';
        $data['error'] = '* that\'s already your email';

    }else{
        $data['result'] = 'fail';
        $data['error'] = '* emails don\'t match';
    }
}else{
    $data['result'] = 'fail';
    $data['error'] = '* some inputs are empty';
}


echo json_encode($data);

?>