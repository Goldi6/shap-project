var backup_ahzaka = <?php echo getFiles('ahzaka'); ?>;

var backup_shomrim = <?php echo getFiles('shomrim'); ?>;

var backup_nikayon = <?php echo getFiles('nikayon'); ?>;

var backup_home = <?php echo getFiles('home'); ?>;

<?php
function getFiles($page){
    $out = array();
    foreach (glob('../back_process/page_update/backup/'.$page.'/*') as $filename) {
        $p = pathinfo($filename);
        $out[] = $p['filename'];
    }
    return json_encode($out);
}
?>