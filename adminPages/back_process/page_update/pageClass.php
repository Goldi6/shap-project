<?php

class Page{
    protected $addToEnd = 'add-toEnd';
    protected $addNew = 'add-New';
    public  $page;
    public  $section;
    public  $create_or_add;
    public  $data;
    public  $backup;
    public  $backup_name;
    public $filename;
    
    public $backupFilePath;

   


    public function __construct(string $page, string $section,string $data, $create_or_add = null ,$backup=null , $backup_name=null) {  

        $this->page =  preg_replace("/\-.*/" , '' , $page);
        $this->section = substr($section , 0 , -5);
        $this->create_or_add = $create_or_add; //add-toEnd \  add-New
        $this->data = $data;
        $this->backup = $backup;
        $this->backup_name = $backup_name;
        $this->filename = '../../../mainWebsite/pages/'.$this->page.'/'.$this->section . '.html';
     
        
    }
 
   public function TestForEmptyData(){
    function spaceCheck($str){
        $str = strip_tags($str);
        $str = str_replace("&nbsp;", "", $str);
        return   !ctype_space($str) && $str !== '' ;
        
    }
    return (!spaceCheck($this->data));
  
   }

public function testEmptyVals(){
    $page = $this->page;
    $section = $this->section; 

    return preg_match('/^(shomrim|home|nikayon|ahzaka)/', $page) + preg_match('/^(main|anhayot|schedule|nehalim)/', $section);
}

   //get file num if name wasn't specified
    private function getFileNum(){
        $page = $this->page;
        $section = $this->section;

        $filter = str_replace("\n",'','$general');
        $path = 'backup/'. $page . '/';

        $numbers =[];
        ////////////////////////////////
         //get all the  files within the path
        $files_inFolder = array_diff(scandir($path), array('.', '..'));
    
        //print_r($files_inFolder);
    

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


    public function fileBackup(){

        if($this->testEmptyVals()===2){


            $page = $this->page;
            $sec = $this->section; 

            $filename = $this->filename;
            
            

            $backup_name= $this->backup_name; //may be null

            //create backup directory if not exists
            if (!file_exists('backup/'.$page)) {
                $dir = 'backup/'.$page;
                mkdir($dir, 0777, true);
            }

            $fileEnd = '_' .$page . '_' . $sec.'.html';

            if(!$backup_name){
                
                $backupNum = $this->getFileNum();

                $backup_Filename = $backupNum . $fileEnd;
            }else{

                $backup_Filename = $backup_name . $fileEnd;
            }
           
          

            $backup_path = 'backup/'. $page .'/'. $backup_Filename;
           // echo '<br>'.$backup_path;

            if(copy($filename, $backup_path)){
                $this->backupFilePath = $backup_path;
                return 'backup created successfully';
            }else{
                return ['fileError','something went wrong with file copy backup'];
            }
        }else{
            return ['selectError' , 'Something\'s wrong with the page'];
        };
        
    }

    public function updateFile(){
        $filename = $this->filename;
        $data = $this->data;
        $add_create = $this->create_or_add;

        if($this->testEmptyVals()===2){

            $f = fopen($filename, 'a');
            if (!$f) {
                return['fileError','Error opening the file ' . $filename];
            }
          
          
            if($add_create == $this->addToEnd){
              fputs($f,$data);
          
              fclose($f);
              return 'successfully added to the end ';
            }else if($add_create ==$this->addNew){
          
              file_put_contents($filename,$data);
              fclose($f);
              return 'successfully created new file ';
          
            }
        }else{
            return ['selectError' , 'Something\'s wrong with the page'];
        };

    }

};