<?php 

session_start();
function clearEmail($email){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    return $email;
}

$data = [];

if(isset($_POST['setEmail']) && isset($_POST['againEmail'])){
    $temp_email = clearEmail($_POST['setEmail']);
    $again_email = clearEmail($_POST['againEmail']);

    $url = $_POST['url'];

    if($temp_email === $again_email && $_SESSION['user_email']!=$temp_email){

        

        $data['temp_email'] = $temp_email;

        ///////////////
        $minutes_to_add = 15;

        $time = new DateTime("now",new DateTimeZone('Asia/Jerusalem'));
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        
        $stamp = $time->format('Y-m-d H:i:s');

        $data['stamp'] = $stamp;
        ////////////////////////
        $token = rand(100000 , 999999);

        require_once '../conn.php';

        $sql =  'INSERT INTO tokens(user_id,token,email_password,temp_value,expiry_time) VALUES(?,?,?,?,?)';
        $stmt   = $conn->prepare($sql);

        try{
            $stmt->execute([$_SESSION['user_id'],$token,'email',$temp_email,$stamp]);
            //set session to prevent second token 
            $randToken = rand(1000,9999);
            $_SESSION['email_token'] = $temp_email; $_SESSION['email_token_exp'] = $stamp; $_SESSION['email_token_rand'] = $randToken;
            $data['email_token'] = $randToken;

            $data['result'] = 'generated';

        }catch(PDOException $e){
            echo $e;
            $data['error'] = '* error generating token';
            $data['result']='fail';
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