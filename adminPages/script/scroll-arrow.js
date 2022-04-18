$(document).ready(function() {
    if ($("#active-messages div:nth-child(4)")) {
        var topOfOthDiv = $("#active-messages div:nth-child(4)").offset().top;
        $(window).scroll(function() {
            if ($(window).scrollTop() > topOfOthDiv) {
                //scrolled past the other div?
                $("#scroll-up").css("visibility", "visible");
                $("#scroll-up").show(200); //reached the desired point -- show div
                //reached the desired point -- show div
            } else {
                $("#scroll-up").hide(200);
            }
        });
        $("#scroll-up").click(() => {
            let formOff = $("#load-msg").offset().top;
            let lineHeight = getComputedStyle(
                document.documentElement
            ).getPropertyValue("--stripe-height");

            lineHeight = convertRemToPixels(parseInt(lineHeight));
            $(window).scrollTop(formOff - lineHeight);
        });
    }

    function convertRemToPixels(rem) {
        return (
            rem * parseFloat(getComputedStyle(document.documentElement).fontSize)
        );
    }
});