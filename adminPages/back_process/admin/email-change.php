<?php

session_start();
require_once 'clearEmail_func.php';
$done = [];

$errors =[];

if(isset($_SESSION['user_email']) && isset($_SESSION['user_id'])){
    $id = $_SESSION['user_id']; $email = $_SESSION['user_email'];

    if(isset($_POST['new-email'])){
        $temp_email = clearEmail($_POST['new-email']);
        $verify_code = isset($_POST['verify-code'])?$_POST['verify-code']:array_push($errors,'* please submit verification code');
    
        $url = $_POST['url'];
    
        if($email != $temp_email){
            
            require_once '../conn.php';
            $query = 'SELECT * FROM tokens WHERE user_id =? AND expiry_time=? AND id=?';
            $stmt=$conn->prepare($query);

            try{

                $stmt->execute([$id ,$_SESSION['email_token_exp'],$_SESSION['email_token_id'] ]);
                if($stmt->rowCount()===1){
                
                    $token = $stmt->fetch();
    
                    $token_id = $token['user_id'];
                    $token_exp = $token['expiry_time'];
                    $token_email = $token['temp_value'];

                    $time = new DateTime("now",new DateTimeZone('Asia/Jerusalem'));
                    $exp = new DateTime($token_exp,new DateTimeZone('Asia/Jerusalem'));
                    
                    if($time < $exp && $token['verified'] ==0){
                        if(password_verify($verify_code,$token['token'])){

                        

                            $query = 'UPDATE tokens SET verified=1 WHERE id=?';
                            $stmt=$conn->prepare($query)->execute([$token['id']]);

                            $query = 'UPDATE users SET email=?,email_verified=? WHERE id=?';
                            $stmt = $conn->prepare($query);

                            try{
                                $stmt->execute([$token_email,1,$token_id]);
                            
                                $done['result'] = 'updated';
                                $done['email'] = $token_email; 
                            
                                $_SESSION['user_email'] = $token_email;
                                unset($_SESSION['email_token']);

                                unset($_SESSION['email_token_exp']);
                                unset($_SESSION['email_token_rand']);
                            }catch(PDOException $e){
                                echo $e;
                                array_push($errors,'* query error');

                            }
                        }else{
                            array_push($errors,'* Incorrect Code!');

                        }
                    }else{
                        array_push($errors,'* token expired, please try again');
                    }


                }else{
                    array_push($errors,'* Session is Incorrect');
                }
            }catch(PDOException $e){
                echo $e;
                array_push($errors,'* query error');
            }
        }else{
            array_push($errors,'* current email match');
        }
    }else{
        array_push($errors,'* email values not posted');
    }
}else{
    array_push($errors, '* user is not logged in');
}
if(!empty($errors)){
    $done['result']='fail';
    $done['error'] = $errors[0];
}
echo json_encode($done);