var files_ahzaka = <?php $out = array();
foreach (glob('../../mainWebsite/pages/ahzaka-cont/*') as $filename) {
    $p = pathinfo($filename);
    $out[] = $p['filename'];
}
echo json_encode($out); ?>;

var files_shomrim = <?php $out = array();
foreach (glob('../../mainWebsite/pages/shomrim-cont/*') as $filename) {
    $p = pathinfo($filename);
    $out[] = $p['filename'];
}
echo json_encode($out); ?>;

var files_nikayon = <?php $out = array();
foreach (glob('../../mainWebsite/pages/nikayon-cont/*') as $filename) {
    $p = pathinfo($filename);
    $out[] = $p['filename'];
}
echo json_encode($out); ?>;

var files_home = <?php $out = array();
foreach (glob('../../mainWebsite/pages/home-cont/*') as $filename) {
    $p = pathinfo($filename);
    $out[] = $p['filename'];
}
echo json_encode($out); ?>;