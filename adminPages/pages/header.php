<?php
session_start();

if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){



?>
<!DOCTYPE html>
<?php   
$pathStyle_inner = '../style/';  $pathStyle_global = '../../globalStyle/';
$pathScript_inner = '../script/';  $pathScript_global ='../../globalScript/';
$pathContent_global = '../../global-content/';

?>
<html lang="he" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <!-- add icon link -->
    <link rel="icon" href="<?php echo $pathStyle_global?>media/SHAP-orange.png" type="image/x-icon">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- richText -->
    <script src="../RichText-master/src/jquery.richtext.min.js"></script>
    <link rel="stylesheet" href="../RichText-master/src/richtext.min.css">
    <!-- fontAwesome -->
    <script src="https://kit.fontawesome.com/b2fc89dd52.js" crossorigin="anonymous"></script>

    <!-- global styles for both sites -->
    <link rel="stylesheet" href="<?= $pathStyle_global?>header&footer.css">
    <link rel="stylesheet" href="<?= $pathStyle_global?>root.css">

    <!-- local styles -->
    <link rel="stylesheet" href="<?= $pathStyle_inner?>root.css">
    <link rel="stylesheet" href="<?= $pathStyle_inner?>style.css">
    <link rel="stylesheet" href="<?= $pathStyle_inner?>aside.css">
    <link rel="stylesheet" href="<?= $pathStyle_inner?>load-msg.css">
    <link rel="stylesheet" href="<?= $pathStyle_inner?>header-query.css">
    <link rel="stylesheet" href="<?= $pathStyle_inner?>alert-errors.css">
    <link rel="stylesheet" href="<?= $pathStyle_inner?>admin-page.css">






    <script str="<?=$pathScript_global?>loadFunc.js"></script>
    <style>
    /*NOTE: user login icon styles*/
    #user {
        position: fixed;
        left: 0;
        background-color: var(--clr-black);
        color: #fff;
        display: none;
        z-index: 5;
        box-shadow: inset 0 0 4px var(--clr-yellow);
        flex-direction: row-reverse;
        padding: 5px;

    }

    #user div {
        padding: 0.5rem;
        text-align: center;
        cursor: pointer;
    }

    #user div:hover {
        color: var(--clr-secondary);
        filter: var(--green-hue-rotate) brightness(155%);
    }

    #user #log-out:hover {
        color: var(--clr-secondary);
        cursor: pointer;
    }

    #user-ico {
        cursor: pointer;
    }

    #user-ico img {
        cursor: pointer;
    }

    #log-out a {
        padding: 3px;
        color: black;
        border-radius: 3px;
        box-shadow: inset 0 5px 5px solid #fff;
        color: var(--clr-yellow);
        font-weight: bold;
        font-size: 0.85rem;
        text-decoration: none;
        background-color: rgba(255, 255, 255, 0.2);
        border: 2px solid white;
    }

    #scroll-up {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        position: sticky;
        top: 70vh;
        right: 0.5rem;
        z-index: 7;
        border: 2px solid white;
        background: url('../style/media/circle-chevron-up-solid.svg') no-repeat center white;
        background-size: 2.5rem 2.5rem;
        visibility: hidden;
    }

    #gotoMain {

        color: var(--clr-secondary);
        margin-left: 1rem;
    }

    #gotoMain:hover {
        filter: hue-rotate(55deg);
    }
    </style>
</head>

<body>
    <button id="scroll-up"></button>

    <?php if(isset($_GET['connerror'])) {?>
    <div id='alert'>
        <?=$_GET['connerror']?>
    </div>
    <?php } ?>
    <nav id="nav">

        <div id="main-nav">
            <span class="logo">
                ?????? <span>Admin</span>
            </span>
            <div id="nav-btns">
                <button id='gotoMain'><a href="">?????? ????????</a></button>
                <button class="nav-btn " value="CreateMsg"><a href="CreateMsg.php">?????? ??????????</a></button>
                <button class="nav-btn" value="EditPages"><a href="EditPages.php">???????? ????????????</a></button>

            </div>


            <button id="user-ico" class='start'> <img style="height:1.25rem;width:1.25rem;"
                    src="<?= $pathStyle_inner?>media/user-tie-solid.svg" alt="user-icon"></button>
        </div>
        <!-- //user -->
        <div id="user">
            <div id='admin-link'>
                <a href="Admin.php">
                    <?=$_SESSION['user_name']?>
                </a>
            </div>


            <div id="log-out">
                <a href='../back_process/login/logout.php'>LogOut</a>
            </div>
        </div>
    </nav>
    <?php include '../pages/success_GET.php';?>

    <script>
    $(() => {
        $('#user-ico').click(() => {
            let $u = $('#user');
            if ($u.css('display') == 'flex') {
                $u.css('display', 'none');
            } else {
                $u.css('display', 'flex');
            }

        })
        if ($('#alert').text() != '')
            alert($('#alert').text());
    })
    </script>
    <?php
    
}else{
    header("Location:../Login.php");
}
    
    ?>