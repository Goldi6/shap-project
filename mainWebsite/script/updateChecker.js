//ajax request for new messages and updates

$(() => {
    setInterval(() => {
        callForUpdates();
    }, 50000);

    function callForUpdates() {
        let page_url = window.location.href;
        // console.log(page_url);
        $.ajax({
            url: "backProccess/get_Update.php",
            type: "POST",
            data: { url: page_url },
            success: function(result) {
                console.log(result);

                if (result == 1) location.reload();
            },
            error: function() {
                console.log("error");
            },
        });
    }
});