<?php
function load($sect) {
    require_once 'shomrim/'.$sect.'.html';
};

?>


<!DOCTYPE html>
<h2 data-page='shomrim'>צוות שומרים</h2>
<section id="messages" class="active ">
    <h3>לוח הודעות</h3>
    <div class="message" id="shomrim-msg">
        <p class="default">כרגע אין הודעות לצוות השומרים.</p>
        <?php
        
        $section='shomrim';
        require '../backProccess/get_messages.php';
        ?>
    </div>
    <h4>לוח הופעות</h4>
    <p>* כאשר יש הופעה בתאטרון נא לר לסגור אורות בלובי</p>


</section>


<?php

require_once 'sections_page.php';
?>