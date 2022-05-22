<?php




$url = isset($_POST['url'])? $_POST['url']:$_COOKIE['backUrl'];
$url = explode('?',$url);
$url = $url[0];
setcookie('backUrl','',time()-3600,'/');
setcookie('backUrl',$url,time()+3600,);



function get_starred($str){
    $len = strlen($str);
    
    return substr($str,0,1).str_repeat('*',$len-2).substr($str,$len-1,1);
}
$domain='http://localhost/websites/shapProject/adminPages';
//TODO: setup domain!
function checkValidUser($stmt, $conn,$url,$domain='http://localhost/websites/shapProject/adminPages'){
    $result = [];
    if($stmt->rowCount()===1){
                
        $user = $stmt->fetch();
        
        $registered_id = $user['id'];

        //check if user already received reset link:
            $query = 'SElECT * FROM tokens WHERE user_id=? AND expiry_time > NOW()';
            $st= $conn->prepare($query);
            $st->execute([$registered_id]);
            if($st->rowCount()>0){
                header('Location:' .$url. "?changePasswordError=We already sent you a link, checkout your inbox!");
            }else{
                if($user['email_verified']==1 ){

                    $registered_email = $user['email'];
        
        
                    $hidden_email_parts = explode('@',$registered_email);
                    $hidden_email = get_starred($hidden_email_parts[0]) . '@' . str_repeat('*',strlen($hidden_email_parts[1]));
                    
        
        
                    require_once 'generate_token_password.php';
        
                    
        
                }else{
                    $error= '* you don\'t have a verified email registered in the system.';
                    $result = ['fail', $error];
                }
            }

       
    }else{
        $result =['* fail','This user doesn\'t exist'];
    }
    return $result;
}


$error = '';
$success = '';
session_start();




if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
    if(filter_var($_SESSION['user_email'],FILTER_VALIDATE_EMAIL)){
        require_once '../conn.php';

        $query = 'SELECT * FROM users WHERE id=? AND username=?';
        $stmt = $conn->prepare($query);
        try{
            $stmt->execute([$_SESSION['user_id'],$_SESSION['user_name']]);
            
            
            $result = checkValidUser($stmt,$conn,$url);
        }catch(PDOException $e){
            $error = '* something is wrong.';
        }
    }else{
        $error =  '* no email is registered please refer to your administrator for help';
    }
}elseif(isset($_POST['submit-reset']) ){
    $email = $_POST['email-reset'];
    $username = $_POST['username-reset'];
    $error = '';
    if ($email != ''){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $term = $email;
            $searchIn ='email'; 
        }else{
            $error = 'incorrect email';
        }
    }elseif($username != ''){
        $term = $username;
        $searchIn = 'username';
    }else{
        $error = '* no data submitted';
    };

    if($error==''){
        require_once '../conn.php';

        $query = 'SELECT * FROM users WHERE '. $searchIn . '=?';
        $stmt = $conn->prepare($query);
        try{
            $stmt->execute([$term]);
            $result = checkValidUser($stmt,$conn,$url);
            
                
        }catch(PDOException $e){
           // echo $e;
           $error = '* something is wrong.';

        }
    }

    
    

}else{
    $error =  '* no data set';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    body {
        width: 100vw;
        height: 100vh;
        display: grid;
        place-items: center;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 1rem;
    }

    p {
        padding: 1rem;
        margin: 0;
    }

    div {
        border-radius: 5px;
        border: 1px solid #333;

    }
    </style>
</head>

<body>
    <?php
if($error !=''){
    header('Location:' .$url. "?changePasswordError=".$error);
}else{
    if(sizeof($result)===2){
        if($result[0]==='fail'){
            header('Location:' .$url. "?changePasswordError=".$result[1]);

        }elseif($result[0]==='success'){
            echo "<div><header >Shap Account Reset</header><p>".$result[1]."</p><p style='text-align:center;color:blue;'>Back to <a href='".$url."'>Webpage</a></p></div>";
    }else{
        header('Location:' .$url. "?changePasswordError=Fail");

        }
    }
}   

die();

?>
</body>

</html>