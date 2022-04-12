<?php


//every worker page has it's path and same func load();
function load($sect) {
    require 'ahzaka/'.$sect.'.html';
};

?>
<!DOCTYPE html>
<h2 data-page='ahzaka'>צוות אחזקה</h2>

<section id="messages" class="active ">
    <h3>לוח הודעות</h3>
    <div class="message-container">
        <div class="message" id="ahzaka-msg">
            <p class="default">כרגע אין הודעות לצוות אחזקה.</p>
            <?php
        
            $section='ahzaka';
            require '../backProccess/get_messages.php';
            ?>
        </div>
    </div>
</section>


<!-- ////////////////////////////////////////////
//////////////////////////////////////////
////////////////////////////////////////////// -->
<?php
//page contains all the sections and load(section) function
require_once 'sections_page.php';
?>