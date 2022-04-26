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
                <form class='toggle-display' action="" id='change-email'>
                    <div class="grid-1">


                        <div class="grid-2">
                            <label for="new-email" placeholder=''>אימייל חדש</label>
                            <label for="repeat-email">אימות אימייל</label>
                            <label for="old-pass" class="verify">קוד אימות</label>
                        </div>
                        <div class="grid-2">
                            <input type="email" name="new-email" id="new-email" autocomplete="on">

                            <input type="email" name="repeat-email" id="repeat-email">

                            <input type="text">
                        </div>
                    </div>
                    <div><input type="submit" value="שלח קוד"></div>
                </form>
                <form class='toggle-display' action="" id="change-password">
                    <div class="grid-1">

                        <div class="grid-2">
                            <label for="old-pass">סיסמא נוכחית</label>
                            <label for="old-pass">סיסמא חדשה</label>
                            <label for="old-pass">אימות סיסמא</label>
                            <!-- <label for="old-pass" class="verify">קוד אימות</label> -->
                            <input type="submit" value="שכחתי" id='forgot-pass'>
                        </div>
                        <div class="grid-2">
                            <input type="password">

                            <input type="password">

                            <input type="password">
                            <!-- <input type="text"> -->
                            <input type="submit" value="עדכן">
                        </div>
                    </div>


                </form>
            </div>


        </div>
        <!-- //////////////////////////// -->
    </section>
    <section class="admin-section-cont">
        <?php
        
        if($_SESSION['user_status']==1){     

            if(file_exists('extra/Admin-user-editor.php')){
        
                include 'extra/Admin-user-editor.php';
            }

        }?>

    </section>
</main>
<script>
$(() => {










    $('.admin-nav-btn').click(function() {
        let btn = $(this);
        const nav = btn.parent();
        let parent = btn.parents('.admin-cont-parent');

        nav.find('.admin-nav-btn').removeClass('active');
        btn.addClass('active');
        ///////////////////
        let toggle = parent.children('.toggle-display');
        for (el of toggle) {
            let dis = window.getComputedStyle(el).display;
            let b = dis == 'none' ? el.style.display = 'block' : el.style.display = 'none'

        }

    });

})
</script>


<?php require $pathContent_global . 'footer.php' ?>