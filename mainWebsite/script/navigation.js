//NOTE: navigation through main pages

const FOLDER = "pages/";
let format = ".php";
$(function() {
    //////////////////////////////////////
    //replace history and load content //[ ] loadPageA()
    function loadPageA(loadPage, page = 0, value = 0) {
        $("main").load(loadPage);
        const clean_url = window.location.href.split("?")[0];
        const url = new URL(clean_url);

        if (page != 0 && value != 0) {
            url.searchParams.append("page", $this.attr("value"));
        }
        window.history.replaceState({}, document.title, url);
    }
    ////////////////////////////////////////
    //////////////////////////////////////////////////////////////////
    //NOTE: prevent hashtags and go to section -<a>
    $("a").click((e) => {
        e.preventDefault();
        var anchor = $(e.target).attr("href").split("#")[1];

        $("#" + anchor + "")[0].scrollIntoView({ behavior: "smooth" });
    });

    //////////////////////////////////
    ///////////////////////////////////

    ///////////////////////////////////

    //#region nav click: load main pages , open secondary nav
    //main pages
    $(".nav-btn").click((e) => {
        //  e.preventDefault();
        $this = $(e.target);
        //#region styles
        //? id to style button
        setupLocationStyles($this.attr("value"));
        /////////////////////////
        //#region  page load
        let loadPage = FOLDER + $this.attr("value") + format;

        loadPageA(loadPage, "page", $this.attr("value"));
        $(window).scrollTop(0);
        $(".small").removeClass("nav-slider");
    });
    //home page
    $(".logo").click(() => {
        $(".nav-btn").removeAttr("id");
        $("#secondary-nav div").hide();
        $(".main-side-navigation-arrow").hide();

        let loadPage = "pages/home" + format;
        ////////
        //NOTE: page load

        loadPageA(loadPage);
    });
    //#endregion
});

//////////////////////////////////////////////
////////////////////////////////////////////
/////////////////////////////////////////////////////
//#region prepare  and load page contents
//on doc load get pages from history and load content+check for mobile
$(document).ready(function() {
    //NOTE: check for mobile nav and remove/switch classes
    if ($(window).width() < 768) {
        $(".big").removeClass("big");
        $(".small").attr("id", "small-mobile");
    }
    //NOTE:load home page when document loads
    if (window.location.href.indexOf("page=") == -1) {
        let name = "home";
        $("main").load("pages/" + name + format);
        $(window).scrollTop(0);
        $(".main-side-navigation-arrow").hide();

        ///////////////////////
    }

    //NOTE: load history
    // get all pages values
    const pageValues = [];
    $(".nav-btn").each(function() {
        pageValues.push($(this).attr("value"));
    });
    // loadPages from history
    pageValues.map(function(name) {
        if (window.location.href.indexOf("page=" + name) > 0) {
            $("main").load(FOLDER + name + format);

            setupLocationStyles(name);
        }
    });
});
//#endregion

//////////////////////////////////////////
///////////////////////////////////////////

////////////////////////////////////////
//////////////////////////////////////

//#region navigation styles
//show arrows, open mid-nav , set active page , set mid-nav position, set tooltip arrow position, scroll top (pageName)
function setupLocationStyles(pageName) {
    $(".nav-btn").removeAttr("id");

    //mid nav
    $("#secondary-nav div").css("display", "flex");
    $("#secondary-nav div.small").css("display", "none");

    //arrows
    $(".main-side-navigation-arrow").show();
    //load content
    //$("main").load(FOLDER + pageName + format);

    $('.nav-btn[value="' + pageName + '"]').attr("id", "active");

    //set tooltip arr distance
    let $this = $("#active");
    let starDistance = $this.offset().left - $this.parent().offset().left;
    $("#secondary-nav div.big").css("padding-left", starDistance + "px");

    //mobile
    let leftDist;
    if (!$("#secondary-nav div").hasClass("big")) {
        leftDist =
            $this.val() == "ahzaka" ?
            "2.5rem" :
            $this.val() == "nikayon" ?
            "6.5rem" :
            $this.val() == "shomrim" ?
            "10.5rem" :
            "";
    }

    document.body.style.setProperty("--arrow-left", leftDist); //set

    $(window).scrollTop(0);
}
//#endregion
///////////////////////////////////
/////////////////////////////////
//////////////////////////////