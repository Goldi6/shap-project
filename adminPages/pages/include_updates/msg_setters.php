<!-- //#region -->
<!-- //FIXME: user shouldnt see those divs in devConsole? -->
<!-- NOTE:load msg after error return -->
<?php if(isset($_SESSION['msg'])) {?>
<div id='hidden-msg' style='display:none;'>
    <?=$_SESSION['msg']?>
</div>
<?php unset($_SESSION['msg']);} ?>

<!-- NOTE: load selected fields after error return -->
<?php if(isset($_SESSION['select'])) {?>
<div id='hidden-select' style='display:none;'>
    <?=$_SESSION['select']?>
</div>
<?php unset($_SESSION['select']);} ?>

<!-- NOTE: load selected fields after error return -->
<?php if(isset($_SESSION['expire'])) {?>
<div id='hidden-expire' style='display:none;'>
    <?=$_SESSION['expire']?>
</div>
<?php unset($_SESSION['expire']);} ?>
<!-- //#endregion -->