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
    array_push($errors, ['section_select' , 'please select a section/s to upload the message']);
    }

        $expire =isset($_POST['expire'])? $_POST['expire'] : '' ;
       
        $expire = date('Y-m-d', strtotime($expire));

        $dateCreated =date("Y-m-d h:i:sa");
        if($expire<$dateCreated){
            $expire = '';
        }

        $message = isset($_POST['richText']) ?  $_POST['richText'] : array_push($errors,['msg', 'No message was submitted']);
        //FIXME: check for empty editor
        // $check = strip_tags($message);
        // $check = ctype_space($check);
       

        // if(preg_replace("/\s+/", "", strip_tags($message))==''){
        //     array_push($errors,['msg', 'No message was submitted']);
        // }

        echo('selected:' . '<br> shomrim = ' . $shomrim . '<br> nikayon = ' .$nikayon. '<br> ahzaka = ' .$ahzaka. '<br>' );
        echo('msg expires on:' .$expire . '<br>');

        echo('created on: ' . $dateCreated .'<br>');

        echo('message: ' . $message );
        echo('err:<br>' );
        if(empty($errors)){
            echo('no errors!');
            require 'msg_insert.php';
        }else{
            print_r($errors);
            $e = '';
            foreach($errors as $error){
                
                $e.= '-'.$error[1];
            }
            $e = ltrim($e, $e[0]);
            echo $e;           
            // $head = '../../pages/CreateMsg.php?error='.$e;
            // header ('Location:'.$head);

        }
      
}else{
    echo isset($_SESSION['id']);
}