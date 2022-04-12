<?php

function load($sect) {
    require_once 'nikayon/'.$sect.'.html';
};

?>


<!DOCTYPE html>
<h2 data-page='nikayon'>צוות נקיון</h2>

<section id="messages" class="active ">
    <h3>לוח הודעות</h3>
    <div class="message" id="nikayon-msg">
        <p class="default">כרגע אין הודעות לצוות נקיון.</p>
        <?php
        
        $section='nikayon';
        require '../backProccess/get_messages.php';
        ?>
    </div>
</section>


<!-- ////////////////////////////////////////////
//////////////////////////////////////////
////////////////////////////////////////////// -->
<?php

require_once 'sections_page.php';
?>