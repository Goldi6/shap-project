<?php
 if(isset($_POST['fileName']) && isset($_POST['page']) && isset($_POST['section']) && isset($_POST['textData'])){

    $filename =$_POST['fileName'];
    $section =  $_POST['section'];
    $page =$_POST['page'];
    $data = $_POST['textData'];
    
    $filename = ($filename==='')? null: $filename;
    

    require 'pageClass.php';
    
    $page_save = new Page($page , $section , $data , null, 1 , $filename);

    if(!$page_save->TestForEmptyData()){

        $result =  $page_save->fileBackup();
    
        if(is_array($result)){
            echo json_encode($result);
        }else{
            echo $page_save->backupFilePath;
        }
    }else{
        echo json_encode(['error',' * text editor is empty']);

    }
 }else{
    echo json_encode(['postError','something\'s wrong with the data']);
}