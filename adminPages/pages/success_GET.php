<?php if(isset($_GET['success']) && isset($_SESSION['message_success'])) {?>

<div class='success msg-to-user' dir='ltr'>
    <?=$_GET['success'];?>
    <span>!</span>
</div>
<?php 
    
    unset($_SESSION['message_success']); 
    
    } ?>