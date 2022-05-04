<?php 


  
session_start();

  
$errors =[];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
  
        $url = $_POST['url'];
        echo $url;
      
        $shomrim = isset($_POST['shomrim-msg'])  ?  1:0;
        $ahzaka = isset($_POST['ahzaka-msg']) ? 1:0;
        $nikayon = isset($_POST['nikayon-msg'])? 1:0;

    if( $shomrim===0 && $ahzaka===0 && $nikayon ===0){
    array_push($errors, ['section_select' , '*please select sections']);
    
    }

        $expire =isset($_POST['expire'])? $_POST['expire'] : '' ;
       
        $expire = date('Y-m-d', strtotime($expire));

        $dateCreated =date("Y-m-d h:i:sa");
        $dateCompare = date("Y-m-d");
        if($expire<$dateCompare){
            $expire = '';
        }
        function spaceCheck($str){
            $str = strip_tags($str);
            $str = str_replace("&nbsp;", "", $str);
            return   !ctype_space($str) && $str !== '' ;
            
        }

        $message = isset($_POST['richText']) && spaceCheck($_POST['richText'])==1 ?  '<div class="single-msg">'.$_POST['richText'] ."</div>": array_push($errors,['msg', '*Empty text field']);

        if(empty($errors)){
            //echo('no errors!');
            require 'msg_insert.php';
            $_SESSION['message_success'] = rand(1000,9999);
            $head = '../../pages/CreateMsg.php?success=ההודעה נשמרה בהצלחה';
             header ('Location:'.$head);
        }else{
            //set selected fields again
            if($expire !=''){
                $_SESSION['expire'] = $expire;

            }

            if (sizeof($errors) ===1){
                if($errors[0][0]=='section_select'){
                    $_SESSION['msg']=$message;
                }elseif($errors[0][0]='msg'){
                    $_SESSION['select']=$shomrim.$ahzaka.$nikayon;
                }
                
            }

            //send the error
            print_r($errors);
            $e = '';
            foreach($errors as $error){
                
                $e.= '<br>'.$error[1];
            }
            $e=substr($e , 4 );
                      
             $head = '../../pages/CreateMsg.php?error='.$e;
             header ('Location:'.$head);

        }
      
}else{
    header ('Location: ../../../../Login.php');
}