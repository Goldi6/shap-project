<!-- //#region -->
<?php 

function createInp($sess,$fieldId){

if(isset($_SESSION[$sess])){
    echo "<div id='".$fieldId."' style='display:none'>";
    echo $_SESSION[$sess];
    echo "</div>";
    unset($_SESSION[$sess]);
}


};

createInp('text' , 'hidden-text');
createInp('create_add' , 'hidden-create_add');
createInp('backup_content','hidden-backup_content');
createInp('backup_name','hidden-backup_name');
createInp('section','hidden-section');
createInp('page','hidden-page');



?>