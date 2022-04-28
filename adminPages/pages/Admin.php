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
                </div>

            </div>

            <div id="user-forms" class='admin-cont-parent'>
                <div class="form-nav">
                    <button class='active admin-nav-btn' id='change-pass-nav'>שנה סיסמא</button><button
                        class='admin-nav-btn' id='change-email-nav'>עדכן אימייל</button>
                </div>
                <form class='toggle-display' action="../back_process/admin/email-change.php" method="post"
                    id='change-email-form' name='change-email-form'>
                    <div class="grid-1">


                        <div class="grid-2">
                            <label for="new-email" placeholder=''>אימייל חדש</label>
                            <label for="repeat-email">אימות אימייל</label>
                            <label for="verify-code" class="verify">קוד אימות</label>
                        </div>
                        <div class="grid-2">
                            <p class='not-allowed'>קוד אימת נשלח לאימייל החדש</p>
                            <input type="email" name="new-email" id="new-email" autocomplete="on">

                            <input type="email" name="repeat-email" id="repeat-email">

                            <input type="text" name="verify-code" id="verify-code" disabled>
                        </div>
                    </div>
                    <div><input type="submit" value="שלח קוד" name='submit-email-change'></div>
                </form>
                <form class='toggle-display' action="../back_process/admin/pass-reset-admin.php" method="post"
                    id="change-password" name="change-password-form">
                    <div class="grid-1">

                        <div class="grid-2">
                            <label for="old-pass">סיסמא נוכחית</label>
                            <label for="new-pass">סיסמא חדשה</label>
                            <label for="retype-new-pass">אימות סיסמא</label>
                            <button id='forgot-pass'>שחכתי סיסמא</button>
                        </div>
                        <div class="grid-2">
                            <p class="not-allowed">* not allowed: '&#38;', '&#34;', '&#60;', '&#62;', '&#39;', '&#47;',
                                '&#92;', ' '.
                            </p>
                            <p class="not-allowed">* passwords not matching.
                            </p>
                            <input type="password" name="old-pass" id="old-pass">
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
<script src='../script/admin-changeForms.js'></script>