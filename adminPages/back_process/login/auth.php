<?php
session_start();
require_once '../conn.php';


//$options =  ['cost' => 12];


$url = $_POST['url'];
if(!isset($er)){

    function strip($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      
    } 



    if(isset($_POST['username']) && isset($_POST['password'])){
        $userName = strip($_POST['username']);
        $password = strip($_POST['password']);


        if(empty($userName) || empty($password)){
            header("Location: ../../Login.php?error=Username and Password are required *");
       

        }else{
        ///////////////////////////


            
            $stmt = $conn->prepare("SELECT * FROM users WHERE Username=?");
            $stmt->execute([$userName]);

            if($stmt->rowCount()===1){
                
                $user = $stmt->fetch();

                $user_id = $user['id'];
                $user_name = $user['username'];
                $user_email = $user['email'];
                $user_status = $user['status'];

            
                
                    if(password_verify($password , $user['password']) && ($user_status>0 && $user_status<9)){

                        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT, $options)){
                            $hash = password_hash($password, PASSWORD_DEFAULT, $options);
                            
                            /* Update the password hash on the database. */
                            
                            try
                            {
                                $res = $conn->prepare('UPDATE users SET password = ? WHERE id = ?');
                                $res->execute([$hash,$user['id']]);
                            }
                            catch (PDOException $e)
                            {
                                header("Location: ../../Login.php?error=Query error *");

                                die();
                            }
                        }
                        $_SESSION['user_id'] =$user_id;
                        $_SESSION['user_name'] = $user_name;
                        $_SESSION['user_email'] = $user_email;
                        $_SESSION['user_status'] = $user_status;
                        header("Location: ../../pages/CreateMsg.php");

                    }else{
                        header("Location: ../../Login.php?error=Incorrect username or password *");

                    }
            
            }else{
                header("Location: ../../Login.php?error=Incorrect username or password *");

            }
        }

        
    }
}
die();
?>