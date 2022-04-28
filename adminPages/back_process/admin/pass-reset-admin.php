<?php

session_start();

$error=[];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {

    $original_pass = isset($_POST['old-pass'])?$_POST['old-pass']:array_push($errors,'please type you current password');
    $new_pass = isset($_POST['new-pass'])?$_POST['new-pass']:array_push($errors,'please type a new password');
    $retype_new_pass = isset($_POST['retype-new-pass'])?$_POST['retype-new-pass']:array_push($errors,'please retype the new password');




}