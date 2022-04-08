<!DOCTYPE html>
<h1>אתר צוות של בית שאפ</h1>
<section id="messages" class="active ">
    <h3>לוח הודעות</h3>
    <div class="message " id="general-msg">
        <?php  
        $filter = str_replace("\n",'','$general');
        $path = '../../adminPages/messages/active/';
        $files_toUpload =[];
        ////////////////////////////////
        //get all the active messages files
        $files_inFolder = array_diff(scandir($path), array('.', '..'));

        //loop through the files to find all relevant files.
        foreach($files_inFolder as $file){

            //?get file content
             $contents = file_get_contents($path . $file);

             //filter to get the php variables
             preg_match_all('/\$[A-Za-z0-9-_]+/', $contents, $vars);

             //get relevant files to $files_toUpload
            if(in_array($filter,$vars[0])){
                array_push($files_toUpload ,$file);
            }

           // print_r($vars[0]);
        }
       // print_r($files_toUpload );
////////////////////////////
//////////////////////////////


//upload/include files in msg section
if(sizeof($files_toUpload)>0){

    foreach( $files_toUpload as $file_namePath){
    
        include $path.$file_namePath;
    }
}else{
    echo '<p class="default">כרגע אין הודעות.</p>';
}       
        ?>
    </div>
</section>
<section id="main">
    <?php require_once 'home/main.html';?>
</section>