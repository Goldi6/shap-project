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
                <span class="alert" id='username-alert' style='display:none;'>

                </span>
                <input type="text" name="username" id="username" placeholder='שם משתמש' autocomplete="username">
                <input type="password" name='password' id='password' placeholder='סיסמא'
                    autocomplete="current-password">
                <input type="submit" name='submit-login' id='submit-login' value='login'>
                <a href="" id='forgot-login'>שכחתי סיסמא</a>
            </fieldset>
        </form>
        <form action="back_process/login/pass-reset.php" method='POST' id='reset-form' name='reset-form-name'
            style="display:none">
            <input type="text" style='display:none' name='url' value='<?=$_SERVER['REQUEST_URI']?>'>

            <p id="legend">שחזור סיסמא</p>
            <fieldset>
                <?php if(isset($_GET['changePasswordError'])) {?>
                <div class='alert'>
                    <?=$_GET['changePasswordError']?>
                </div>
                <?php } ?>
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
                <div id='reset-links-cont'><a href="#" id='reset-by-email'>אימייל</a><a id='reset-by-name' href="#">שם
                        משתמש</a></div>
                <input type="text" name="username-reset" id="username-reset" placeholder='שם משתמש'>
                <input type="email" name='email-reset' id='email-reset' placeholder='אימייל' style="display:none">
                <input type="submit" name='submit-reset' id='submit-reset' value='send'>
                <a href="" id='back-login'>חזור</a>

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
    e.preventDefault();
    if (/\W/.test(username.value) || username.value.length === 0) {
        alert.innerHTML = '* Only alphanumeric values and underscore in username';
        alert.style.display = 'block';
    } else {
        alert.style.display = 'none';
        this.submit();

    }
})

const formsContainer = document.getElementById('login-container');




const resetForm = document.getElementById("reset-form");
const loginForm = document.getElementById("login-form");

const nameResetField = document.getElementById("username-reset");
const emailResetField = document.getElementById("email-reset");

//console.log(resetForm);
document.getElementById('reset-by-name').addEventListener('click', function(e) {
    e.preventDefault();

    resetForm.setAttribute('name', 'reset-form-name');
    emailResetField.style.display = 'none';
    nameResetField.style.display = 'block';

});
document.getElementById('reset-by-email').addEventListener('click', function(e) {
    e.preventDefault();

    resetForm.setAttribute('name', 'reset-form-email');
    nameResetField.style.display = 'none';
    emailResetField.style.display = 'block';

});



document.getElementById("back-login").addEventListener("click", (e) => {
    e.preventDefault();
    resetForm.style.display = 'none';
    loginForm.style.display = 'block';
});
document.getElementById("forgot-login").addEventListener("click", (e) => {
    e.preventDefault();

    resetForm.style.display = 'block';
    loginForm.style.display = 'none';
});


(function() {
    let params = (new URL(document.location)).searchParams;
    if (params.has('changePasswordError')) {
        resetForm.style.display = 'block';
        loginForm.style.display = 'none';
    }



})();
</script>
<script>
(function() {

    setTimeout(() => {
        let currentUrl = window.location.href;
        let clearUrl = currentUrl.split('?');
        history.pushState(null, document.title, clearUrl[0]);
    }, 500);
})();
</script>

</html>