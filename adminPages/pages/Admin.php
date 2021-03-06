<?php require 'header.php';?>
<main class='admin-main'>

    <section class="admin-section-cont">
        <!-- ///////////////////////////////////////////////// -->
        <h3>הגדרות פרופיל</h3>


        <div class="admin-section" id='user-settings'>


            <div id='user-data' class="admin-info">

                <div class="grid-1">
                    <div id="user-data-key" class='grid-2'>
                        <p>שם משתמש:
                        </p>
                        <p>סטטוס:
                        </p>
                        <p>אימייל:
                        </p>
                    </div>
                    <div id="user-data-content" class='grid-2'>
                        <span><?= $_SESSION['user_name']?></span>
                        <span><?=$_SESSION['user_status']?></span>
                        <span><?=$_SESSION['user_email']?></span>
                    </div>
                    <p id='email-note'>שים לב! לא תהייה באפשרותך לשחזר סיסמא ללא כתובת אימייל במידה ולא תהייה מחובר
                        למערכת
                </div>
                </p>
            </div>

            <div id="user-forms" class='admin-cont-parent'>
                <div class="form-nav">
                    <button class='active admin-nav-btn' id='change-password-nav'>שנה סיסמא</button><button
                        class='admin-nav-btn' id='change-email-nav'>עדכן אימייל</button>
                </div>
                <form class='toggle-display' action="../back_process/admin/email-change.php" method='POST'
                    id='change-email-form' name='change-email-form'>
                    <?php if(isset($_GET['changeEmailError'])) {?>
                    <div class='alert' style="white-space: pre-line">
                        <?=$_GET['changeEmailError']?>
                    </div>
                    <?php } ?>
                    <div class='alert' id='emailSet-error' style="white-space: pre-line" style='display:none'>
                    </div>
                    <div class='alert' id='emailSet-stamp' style="white-space: pre-line;display:none;color:orange;">
                    </div>
                    <input type="text" style='display:none' name='url' value='<?=$_SERVER['REQUEST_URI']?>'>
                    <div class="grid-1">


                        <div class="grid-2">
                            <label for="new-email" placeholder=''>אימייל חדש</label>
                            <label for="repeat-email">אימות אימייל</label>
                            <label for="verify-code" class="verify">קוד אימות</label>
                        </div>
                        <div class="grid-2">
                            <p class='not-allowed'>קוד אימת נשלח לאימייל החדש</p>
                            <input type="email" name="new-email" id="new-email" autocomplete="on" autocomplete="email">

                            <input type="email" name="repeat-email" id="repeat-email" autocomplete="email">

                            <input type="text" name="verify-code" id="verify-code" disabled
                                autocomplete="one-time-code">
                        </div>
                    </div>
                    <div><input type="submit" value="שלח קוד" name='submit-email-change'></div>
                </form>
                <form class='toggle-display' action="../back_process/admin/pass-reset-admin.php" method="post"
                    id="change-password-form" name="change-password-form">
                    <?php if(isset($_GET['changePasswordError'])) {?>
                    <div class='alert' style="white-space: pre-line">
                        <?=$_GET['changePasswordError']?>
                    </div>
                    <?php } ?>
                    <input type="text" style='display:none' name='url' value='<?=$_SERVER['REQUEST_URI']?>'>

                    <div class="grid-1">

                        <div class="grid-2">
                            <label for="old-pass">סיסמא נוכחית</label>
                            <label for="new-pass">סיסמא חדשה</label>
                            <label for="retype-new-pass">אימות סיסמא</label>
                            <a id='forgot-pass'>שחכתי סיסמא</a>
                        </div>
                        <div class="grid-2">
                            <p class="not-allowed">* not allowed: '&#38;', '&#34;', '&#60;', '&#62;', '&#39;', '&#47;',
                                '&#92;', ' '.
                            </p>
                            <p class="not-allowed">* passwords not matching.
                            </p>
                            <input type="password" name="old-pass" id="old-pass" autocomplete="current-password">
                            <input type="password" name="new-pass" id="new-pass">

                            <input type="password" name="retype-new-pass" id="retype-new-pass">
                            <input type="submit" value="עדכן" name='submit-pass-change'>
                        </div>
                    </div>


                </form>
            </div>


        </div>
        <!-- //////////////////////////// -->
    </section>
    <?php
        
        if($_SESSION['user_status']==1){     

            if(file_exists('extra/Admin-user-editor.php')){
        
                include 'extra/Admin-user-editor.php';
            }

        }?>

</main>



<?php require $pathContent_global . 'footer.php' ?>
<?php if( isset($_SESSION['email_token_exp']) && isset($_SESSION['email_token_rand'])){
    $time = new DateTime("now",new DateTimeZone('Asia/Jerusalem'));
    $exp = new DateTime($_SESSION['email_token_exp'],new DateTimeZone('Asia/Jerusalem'));
    
    if($time > $exp){
               
                
                unset($_SESSION['email_token']);

                unset($_SESSION['email_token_exp']);
            }else{
                ?>
<script>
$(() => {
    window.id_to_timer = "emailSet-stamp";
    window.time_to_timer = "<?=$_SESSION['email_token_exp']?>";
    window.email_token = "<?=$_SESSION['email_token_rand']?>";
    $.getScript("../script/timer.js");

    window.form = document.forms["change-email-form"];
    window.inputs = form.elements;
    for (inp of inputs) {
        if (inp.type === "email") {
            inp.setAttribute('value', '<?=$_SESSION['email_token']?>');
        }

    }


    $.getScript("../script/Admin_set_email_values.js");



})
</script>
<?php
            }
}


?>
<script src='../script/admin-changeForms.js'></script>
<script>
let emailNote = document.getElementById('email-note');
let emailStatus = document.getElementById('user-data-content').getElementsByTagName('span')[2].textContent;
if (emailStatus === '* no email was set') {
    emailNote.style.display = 'block';
}
</script>

<?php
if($_SESSION['user_status']==1){     

if(file_exists('extra/verify.js') && file_exists('extra/admin-fetch-users.js')){
?>
<?="<script src='extra/verify.js'></script>"?>
<?="<script src='extra/admin-fetch-users.js'></script>"?>

<?php }

}?>