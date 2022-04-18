<?php 
session_start();



  
$errors =[];
$url = $_POST['url'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

        $id= isset($_POST['id']) ? $_POST['id']: array_push($errors,['no msg id was sent']);
        $created = isset($_POST['original_date']) ? $_POST['original_date']:  array_push($errors,['can\'t get required data']);

        $delete = isset($_POST['delete'])? $_POST['delete']: array_push($errors,['delete field']);
        $frz = isset($_POST['frz'])? $_POST['frz']: array_push($errors,['frz field']);
        $exp = isset($_POST['exp'])? $_POST['exp']: array_push($errors,['exp field']);
        $status = isset($_POST['status'])? $_POST['status']: array_push($errors,['status field']);
        $newDate = isset($_POST['newExp'])? $_POST['newExp']: array_push($errors,['newExp field']);

        $nik = isset($_POST['nik']) ? $_POST['nik']: array_push($errors, ['nik field']);
        $sho = isset($_POST['sho']) ? $_POST['sho']: array_push($errors, ['sho field']);
        $ahz = isset($_POST['ahz']) ? $_POST['ahz']: array_push($errors, ['ahz field']);

//  echo "id: " . $id . " . created: " . $created . " , delete: " .$delete. " . frz: " . $frz . " . exp: " .$exp . "status: ". $status . " newDate: ". $newDate ." nik:". $nik ." sho:.". $sho ." ahz:". $ahz ;


         $today = date('Y-m-d');
         $EXP = $newDate !=''? $newDate: $exp; 


        if($frz == 1){
                 if($status == 'active' && ($EXP > $today || $exp == '0000-00-00' ) ){
                        $STAT = 'frozen';
                        
                }elseif($status == 'frozen'){
                        $STAT = 'active';
                        $EXP = $EXP > $today ? $EXP : '';

                }elseif($status == 'expired'){
                        $STAT = 'active';

                        $EXP = $EXP>$today ? $EXP:'';
                     
                }
        }else{
                //echo $status;
               // echo "check: " . ($status == 'active') . "<br>.";
                $STAT = $status;

        }


     // echo "stat: " . $STAT . " EXP: " . $EXP;
     function getId($id,$created ,$conn){
        $query = "SELECT id FROM messages WHERE random_id=? AND create_date=?";
        $stmt=$conn->prepare($query);
        $stmt->execute([$id , $created]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $origin_id = $row['id'];
        }
        return $origin_id;
     };


         if(!empty($errors)){
                echo 'something is wrong with the data: '. json_encode($errors);
        }else{
                require_once '../conn.php';

                $origin_id = getId($id,$created, $conn);

                $query = "UPDATE messages SET shomrim=?,nikayon=? ,ahzaka=?,stat=?,expire_date=?,updated_by=? WHERE id=? ";

                $stmt = $conn->prepare($query);
                $stmt->execute([$sho,$nik,$ahz,$STAT,$EXP,$_SESSION['user_name'],$origin_id]);

                $query ="SELECT * FROM messages WHERE id=?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$origin_id]);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $data = ['result'=>'updated','stat'=>$row['stat'], 'expire'=> $row['expire_date'],'sho'=> $row['shomrim'],'nik'=> $row['nikayon'], 'ahz'=> $row['ahzaka']];
                }

                echo json_encode($data);
               $conn = null;
       }

  
       


      
}else{
        echo 'error';
}