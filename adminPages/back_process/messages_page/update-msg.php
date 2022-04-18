<?php 
session_start();



  
$errors =[];
$url = $_POST['url'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {

        $id= isset($_POST['id']) ? $_POST['id']: array_push($errors,['no msg id was sent']);
        $created = isset($_POST['original_date']) ? $_POST['original_date']:  array_push($errors,['can\'t get required data']);

        $delete = isset($_POST['delete'])? isset($_POST['delete']): array_push($errors,['delete field']);
        $frz = isset($_POST['frz'])? isset($_POST['frz']): array_push($errors,['frz field']);
        $exp = isset($_POST['exp'])? isset($_POST['exp']): array_push($errors,['exp field']);
        $status = isset($_POST['status'])? isset($_POST['status']): array_push($errors,['status field']);
        $newDate = isset($_POST['newExp'])? isset($_POST['newExp']): array_push($errors,['newExp field']);

        $nik = isset($_POST['nik-check']) ? $_POST['nik-check']: array_push($errors, ['nik field']);
        $sho = isset($_POST['sho-check']) ? $_POST['sho-check']: array_push($errors, ['sho field']);
        $ahz = isset($_POST['ahz-check']) ? $_POST['ahz-check']: array_push($errors, ['ahz field']);

// echo "id: " . $id . " .<br>created: " . $created . " .<br>delete: " .$delete. " .<br>frz: " . $frz . " .<br>exp: $exp .<br>
// status: $status .<br> newDate: $newDate .<br>nik: $nik .<br>sho: $sho .<br>ahz: $ahz .";


        // $today = date("yyyy-mm-dd");

        // if($frz == 1){
        //         if($status == 'active' && ($exp > $today || $exp == '0000-00-00' ) ){
        //                 $STAT = 'frozen';
        //         }elseif($status == 'frozen'){
        //                 $STAT == 'active';
        //                 $EXP = $newDate != '' ? $newDate : ($exp > $today ? $exp: '0000-00-00');

        //         }elseif($status == 'expired'){
        //                 $STAT = 'active';

        //                 $EXP = $newDate==''? '0000-00-00':$newDate;
                     
        //         }
        // }else{
        //         $STAT = $status =='active' || $expired ? 'active': 'frozen' ;
        //         $EXP = $newDate !=''? $newDate: $exp; 

        // }


      


        // if(!empty($errors)){
        //         echo 'something is wrong with the data: '. json_encode($errors);
        // }else{
        //         require_once '../conn.php';

        //         $query = "UPDATE messages SET shomrim=?,nikayon=? ,ahzaka=?,stat=?,expire_date=?,updated_by=? WHERE random_id=? AND create_date=?";

        //  $stmt = $conn->prepare($query);
        //  $stmt->execute([$sho,$nik,$ahz,$STAT,$EXP,$_SESSION['user_name'],$id,$created]);


                echo 'updated';
       // }

  
       


      
}else{
        echo 'error';
}