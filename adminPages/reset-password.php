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

    #login-container a {
        font-size: small;
        color: var(--clr-secondary);
        text-decoration: underline;
    }

    #login-container a:hover {
        filter: brightness(65%);
    }

    #login-container a:active {
        color: #333;
    }

    #reset-links-cont {
        display: flex;
        justify-content: space-evenly;
        gap: 3rem
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
        <form action="" method='POST' id='reset-form'>
            <input type="text" style='display:none' name='url' value='<?=$_SERVER['REQUEST_URI']?>'>

            <p id="legend">שינוי סיסמא</p>
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

                <input type="password" name='new-password' id='new-password' placeholder='סיסמא חדשה'>
                <input type="password" name='retype-new-password' id='retype-new-password' placeholder='אימות סיסמא'>
                <input type="submit" name='submit-pass-reset' id='submit-pass-reset' value='עדכן סיסמא'>
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
</script>

</html>