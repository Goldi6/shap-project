<?php session_start();
 if(isset($_SESSION['user_id']) && isset($_SESSION['user_name'])){
                    echo $_SESSION['user_id'];

    header('Location:pages/CreateMsg.php');
    exit();
}?>

<?php $pathStyle_global='../globalStyle/';?>
<!DOCTYPE html>
<html lang="he" dir='rtl'>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../globalStyle/header&footer.css">
    <link rel="stylesheet" href="../globalStyle/root.css">

    <link rel="stylesheet" href="style/root.css">
    <link rel="stylesheet" href="style/index-login.css">



    <style>
    a,
    a:hover,
    a:focus,
    a:active {
        text-decoration: none;
        color: inherit;

    }

    #login-link {
        transform: skew(20deg);

    }
    </style>
</head>


<body>

    <nav id="nav">

        <div id="main-nav">
            <a href="" id='login-link'>
                <span class="logo">
                    שאפ <span>Admin</span>
                </span>
            </a>
        </div>

    </nav>
    <div id='login-container'>
        <form action="back_process/login/auth.php" method='POST' id='login-form'>
            <input type="text" style='display:none' name='url' value='<?=$_SERVER['REQUEST_URI']?>'>

            <p id="legend">כניסת משתמש</p>
            <fieldset>

                <?php if(isset($_GET['error'])) {?>
                <div class='alert'>
                    <?=$_GET['error']?>
                </div>
                <?php } ?>
                <?php if(isset($_GET['connerror'])) {?>
                <div class='alert'>
                    <?=$_GET['connerror']?>
                </div>
                <?php } ?>

                <input type="text" name="username" id="username" placeholder='שם משתמש'>
                <input type="password" name='password' id='password' placeholder='סיסמא'>
                <input type="submit" name='submit' id='submit' value='login'>
            </fieldset>
        </form>
    </div>
    <?php include '../global-content/footer.php';?>
</body>
<script>
function url() {
    var u = window.location.href;
    u = u.split('?');
    u = u[0];
    return u;
}
const link = document.getElementById('login-link');
link.href = url();

///////////////////
/////////////////////////
const username = document.getElementById('username');
const alert = document.getElementById('username-alert');
const form = document.getElementById('login-form');
//console.log(alert);

form.addEventListener('submit', function(e) {
    if (/\W/.test(username.value) || username.value.length === 0) {
        e.preventDefault();
        // console.log(alert);
        alert.innerHTML = '* Only alphanumeric values and underscore in username';
        alert.style.display = 'inline-block';
    } else {
        alert.style.display = 'none';

    }
})
</script>

</html>