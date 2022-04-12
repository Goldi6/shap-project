$(document).ready(function() {
    if ($("#messages").text() == "") {
        //FIXME: why thats not working???
        $(".default").show();
    }

    $(".success").fadeOut(5000);
    //checkStatus();
});

// function checkStatus() {
//     $("#el").load("status.php");
//     setTimeout(checkStatus, 2000);
// }

$(() => {});