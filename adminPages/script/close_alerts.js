$(() => {
    $(".alert-container .alert button").click(function() {
        $(this).parent().parent().remove();
        let url = window.location.href;
        url = url.split("?");

        window.location.href = url[0];
    });
});