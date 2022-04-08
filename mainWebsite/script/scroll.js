$(() => {
    var timeout;
    $(window).on("load scroll resize", function() {
        if (timeout) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function() {
            var $window = $(window),
                hitbox_top = $window.scrollTop() + $window.height() * 0.25,
                hitbox_bottom = $window.scrollTop() + $window.height() * 0.55;
            $("section").each(function() {
                var $element = $(this),
                    element_top = $element.offset().top,
                    element_bottom = $element.offset().top + $element.height();
                $element.toggleClass(
                    "middle-viewport",
                    hitbox_top < element_bottom && hitbox_bottom > element_top
                );
                if (hitbox_top < element_bottom && hitbox_bottom > element_top) {
                    let id = $element.attr("id");
                    $("#secondary-nav > div.upper-nav > a").removeAttr("id");
                    $('.upper-nav a[href="#' + id + '"]').attr("id", "active-a");
                }
            });
        }, 200);
    });

    //click on arrows
    //#region arrow navigation
    $("#down").click(() => {
        let $target = $("section.middle-viewport").next();
        arrowSlide($target);
    });
    $("#up").click(() => {
        let $target = $("section.middle-viewport").prev();
        arrowSlide($target);
    });

    function arrowSlide($target) {
        let id = $target.attr("id");
        let a = $('a[href="#' + id + '"]');
        // if (!$("#secondary-nav div").is(":visible")) {
        //     $("#secondary-nav div").css("display", "flex");
        // }

        a.trigger("click");
    }
    //#endregion
});