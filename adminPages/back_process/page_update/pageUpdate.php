<?php 



  
$errors =[];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
          // get section and page
          if(isset($_POST['page-select'])) {

            $page = $_POST['page-select']; //page-cont-edit
            echo $page;
            $clearPageName_regex = "/\-.*/";
            $page = preg_replace($clearPageName_regex , '' , $page);
            //$page = substr($page , 0 , -5);  // page-cont
            echo '<br>page: ' . $page;
        }else{
            array_push($errors,['page', 'No page Selected']);
        } 
        if(isset($_POST['section-select'])){

            $section = $_POST['section-select']; //section-cont
            $sec = substr($section , 0 , -5);  //section
            $section = '/'.substr($section , 0 , -5); // '/section
            $sectionHtml = $section . '.html'; // 'section.html

            echo '<br>section: ' . $section;


        }else{
            array_push($errors,['page', 'No section Selected']);

        }
       
        //create path
        $filename = '../../../mainWebsite/pages/'.$page. $sectionHtml;
        
        //get backup checkbox
        $backup = isset($_POST['backup-content']) ? 1:0;
        echo '<br>backup: '. $backup;

        //create file copy

        /////
        if($backup===1){

            if (!file_exists('backup/'.$page)) {
                $dir = 'backup/'.$page;
                mkdir($dir, 0777, true);
            }

            $backup_name= isset($_POST['backup-name'])? $_POST['backup-name']:'';
            $fileEnd = '_' .$page . '_' . $sec.'.html';
            echo '<br>name: ' .$backup_name .'\n';
            if($backup_name==''){
                
                $backupNum = getFileNum($page , $sec);
                print_r($backupNum);

                $backup_Filename = $backupNum . $fileEnd;
            }else{

                $backup_Filename = $backup_name . $fileEnd;
            }
           
          

            $backup_path = 'backup/'. $page .'/'. $backup_Filename;
            echo '<br>'.$backup_path;

            if(copy($filename, $backup_path)){
                echo '<br>backup created successfully';
            }else{
                array_push($errors,['copy', 'something went wrong with file copy']);
            }
        }
        

        if(isset($_POST['create_Or_add'])){

            $add_create = $_POST['create_Or_add'];
            echo '<br>add/create: ' . $add_create;
        }else{
            array_push($errors,['createOrAdd', 'No section Selected']);

        }

        
        if(isset($_POST['richText']) ){

            $data =  $_POST['richText']; 
        }else{
            array_push($errors,['msg', 'Text editor is empty']);

        }
       



        echo('<br>data: ' . $data);

          //////////////////////////////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////////
  /////////////////////////////////////////////////////
  //////////////////////////////////////////////
  $f = fopen($filename, 'a');
  if (!$f) {
      die('Error opening the file ' . $filename);
  }


  if($add_create == 'add-toEnd'){
    fputs($f,$data);

    fclose($f);
  }else if($add_create =='add-New'){

     

file_put_contents($filename,$data);
      fclose($f);

  }




////////////////////////////////

//////////////////////////////



//TODO: get the numbers for file names


  


}

//get file num if name wasn't specified
function getFileNum($page , $section){

    $filter = str_replace("\n",'','$general');
    $path = 'backup/'. $page . '/';

    $numbers =[];
////////////////////////////////
//get all the  files within the path
    $files_inFolder = array_diff(scandir($path), array('.', '..'));
    echo 'dsdlfjldskfjsldf:<br><br>';
    print_r($files_inFolder);
    echo '<br>dsdlfjldskfjsldf:<br><br>';


//loop through the files to find all relevant files.
    if (sizeof($files_inFolder)===0){
        //if no files found the file will be number 1
        $number =0;
    }else{
        $matches =[];
        foreach($files_inFolder as $file){
        
        //look for files that start with digits
            $regex = '/^\d+_'.$page.'_'.$section.'/';
            preg_match_all($regex, $file, $vars,PREG_UNMATCHED_AS_NULL);
            $var= array_shift($vars);
            $var = array_shift($var);
            if(strlen($var)>0){
                array_push($matches , $var);
            }
        }
    // echo '<br>vars: ';
    // print_r($matches);
    // echo '<br>';
        $numbers = [];
        foreach($matches as $num){
                   $regex = '/^\d+/';
                preg_match_all($regex , $num, $nums);
                $nums = array_shift($nums);
                $nums = array_shift($nums);
                array_push($numbers,$nums);
        }
        if(count($numbers)>0){
            $number = max($numbers);
        }else{
            $number = 0;
        }
    //echo '<br> number: '.$number . '<br>';
    
    }
 return $number+1;
  
}
?>