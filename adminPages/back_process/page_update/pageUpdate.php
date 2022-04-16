<?php 

session_start();
//TODO: errors , session , messages , header



//#region session and header funcs
function setDataSession(){
    function spaceCheck2($str){
        $str = strip_tags($str);
        $str = str_replace("&nbsp;", "", $str);
        return   !ctype_space($str) && $str !== '' ;
        
         };
    if(isset($_POST['richText'])){
             
        if(spaceCheck2($_POST['richText'])){

            $data =  $_POST['richText'];
           $_SESSION['text'] = $data;
        }
    }
    if(isset($_POST['create_or_add'])){
             

        $data =  $_POST['create_or_add'];
       $_SESSION['create_add'] = $data;
    
    }
    if(isset($_POST['backup-content'])){
             
       $_SESSION['backup_content'] = 1;
       if(isset($_POST['backup-name'])){
             
        $_SESSION['backup_name'] = $_POST['backup-name'];
     
        }
    }
    if(isset($_POST['section-select'])){
             

        $data =  $_POST['section-select'];
       $_SESSION['section'] = $data;
    
    }
    if(isset($_POST['page-select'])){
             

        $data =  $_POST['page-select'];
       $_SESSION['page'] = $data;
    
    }
}
function msgHeader($arr){
    setDataSession();
    $errMsg = $arr[0].'='.$arr[1];

    $head = '../../pages/EditPages.php?'.$errMsg;
    header ("Location:" . $head);

}
//endregion
  
//error(block) , selectError(alert),fileError(alert),


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    try{


        include 'pageClass.php';

        $backup = isset($_POST['backup-content']) ? 1:null;
        if($backup){
            $backup_name= isset($_POST['backup-name'])? $_POST['backup-name']: false; 
            if($backup_name){
                $page_update = new Page($_POST['page-select'],$_POST['section-select'], $_POST['richText'],$_POST['create_or_add'], 1, $backup_name);
            }else{
            $page_update = new Page($_POST['page-select'],$_POST['section-select'], $_POST['richText'],$_POST['create_or_add'], 1); 
            }
        }else{

        $page_update = new Page($_POST['page-select'],$_POST['section-select'], $_POST['richText'] ,$_POST['create_or_add']);
        }
//?thats usable???
    }catch(exception $e){
       // echo "<br>tTTTTT ". $e->getMessage() . "TTTT<br>";

       msgHeader(['selectError','Something is wrong with the page']);
      
    }


    if($page_update->testForEmptyData() ==1){

        msgHeader(['error','*Nothing was sent, please add some text to the Editor']);
     
    };
  
    if($page_update->testEmptyVals() !==2){

           msgHeader(['selectError','Something is wrong with the page']);
          

    };

    ////////////////////////////////////////////////////////////

    if($page_update->backup===1){

        $backupMsg = $page_update->fileBackup();
        if(is_array($backupMsg)){


          msgHeader($backupMsg);
        }else{
             $successBackup = "&backupSuccess=".$backupMsg;
        }
    }else{
        $successBackup = '';
    }

    $updateFile = $page_update->updateFile();
    if(is_array($updateFile)){
        
        msgHeader($updateFile);

    }else{
        
        //#region update user table for main page updating and refresh
        require_once '../conn.php';  
        require_once '../update_mysql.php';
        //#endregion
        $_SESSION['message_success'] = rand(1000,9999);
        msgHeader(['success', $updateFile.$successBackup]);
        //echo $updateFile;
    }



 

   

}


?>