<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

    $sho = isset($_POST['sho'])? $_POST['sho'] : array_push($errors , 'error getting \'shomrim\' value'); 
    $nik = isset($_POST['nik'])? $_POST['nik'] : array_push($errors , 'error getting \'nikayon\' value'); 
    $ahz = isset($_POST['ahz'])? $_POST['ahz'] : array_push($errors , 'error getting \'ahzaka\' value'); 
    $empty =isset($_POST['empty'])?$_POST['empty'] :array_push($errors , 'error getting not \'categorized\' value'); 

    require_once '../conn.php';


    if($sho ==0 && $nik==0 && $ahz==0 && $empty==0){
        echo 0;
    }elseif($sho !=0 || $nik!=0 | $ahz!=0){



        $arr = ['shomrim'=>$sho , 'ahzaka'=>$ahz, 'nikayon'=>$nik];
        $set = [];
        foreach( $arr as $key=>$value){
            if($value ==1){
            array_push($set,' '. $key . '=1 ');
            }
        }
        //print_r($set);

        $exp = join('OR' , $set);

        //echo $exp;




        $query ='SELECT * FROM messages WHERE '.$exp.' ORDER BY stat';

        $stmt = $conn->prepare($query);
        $stmt->execute([$sho , $nik , $ahz]);

        $data = [];
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $object = (object) array('msg' => $row['msg'], 'stat'=>$row['stat'],'expire'=>$row['expire_date'],'id'=>$row['random_id'],'sho'=> $row['shomrim'],'nik'=> $row['nikayon'], 'ahz'=> $row['ahzaka'], 'origin'=> $row['create_date']); 

                array_push($data ,$object );
        }

        if($empty == 1){
            $query = 'SELECT * FROM messages WHERE shomrim="0" AND nikayon="0" AND ahzaka="0"';
            
            $stmt = $conn->prepare($query);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $object = (object) array('msg' => $row['msg'], 'stat'=>$row['stat'],'expire'=>$row['expire_date'],'id'=>$row['random_id'],'sho'=> $row['shomrim'],'nik'=> $row['nikayon'], 'ahz'=> $row['ahzaka'], 'origin'=> $row['create_date']);  
                array_push($data ,$object );

            } 
        }
        echo json_encode($data);


    }elseif($sho ==0 && $nik==0 && $ahz==0 && $empty==1){
        $data = [];
        
         $query = 'SELECT * FROM messages WHERE shomrim="0" AND nikayon="0" AND ahzaka="0"';
         
         $stmt = $conn->prepare($query);
         $stmt->execute();

         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
             $object = (object) array('msg' => $row['msg'], 'stat'=>$row['stat'],'expire'=>$row['expire_date'],'id'=>$row['random_id'],'sho'=> $row['shomrim'],'nik'=> $row['nikayon'], 'ahz'=> $row['ahzaka'], 'origin'=> $row['create_date']);  
             array_push($data ,$object );

         } 
        
        echo json_encode($data);
    }
    $conn = null;
}