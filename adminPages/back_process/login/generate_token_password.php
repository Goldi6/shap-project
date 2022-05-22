<?php
$error = '';



//$registered_email
//$registered_id

$token = md5($registered_email) . rand(10 , 99999);
 ///////////////
 $minutes_to_add = 15;

 $time = new DateTime("now",new DateTimeZone('Asia/Jerusalem'));
 $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
 
 $stamp = $time->format('Y-m-d H:i:s');
//////////////

 $query = 'INSERT INTO tokens(user_id,token,email_password,verified,expiry_time) VALUES(? ,? ,? ,?,?)';

 $stmt = $conn->prepare($query);

try{
    $stmt->execute([$registered_id,$token,'password',0,$stamp]);
    $link = "<a href='".$domain."/reset-password.php?key=".$registered_email."&token=".$token."'>Click To Reset your password</a>";
    $emailContent = $link . "<p>This token expires at: ".$stamp."</p>";
   
    require_once "send_token_toEmail.php";


}catch(PDOException $e){

    echo $e;
    $error = '* something is wrong, try again later';
}

////////////////////
if($error==='' && $emailSuccess){

    $success =  'Reset token was sent to ' . $hidden_email;
    $result = ['success',$success];
}else{
    header("Location:".$url."?changePasswordError=".$error);
}
?>