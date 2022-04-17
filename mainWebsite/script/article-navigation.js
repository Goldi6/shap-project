//get section name add nav by title
$(document).ready(function() {
    // window.setTimeout(function() {
    //     let articles = getSections("article");
    //     console.log(articles);
    //     articles = articles.map((id) => {
    //         return `<a href='#${id}'>${id}</a>`;
    //     });
    //     articles.join("");
    //     $("#secondary-nav .small").html(articles);
    // }, 500);

    function addObserverIfDesiredNodeAvailable() {
        var mainContainer = document.querySelector("main");
        if (!mainContainer) {
            //The node we need does not exist yet.
            //Wait 500ms and try again
            window.setTimeout(addObserverIfDesiredNodeAvailable, 500);
            return;
        }

        const observer = new MutationObserver((mutations) => {
            $("#secondary-nav a").removeClass();
            $(".small").empty();
            ///////////////////////////////////
            //messages overflow padding-style correction

            let messagesBlock = document.querySelector(".message");

            if (check(messagesBlock)) {
                messagesBlock.style.paddingTop = "6rem";
            }

            function check(el) {
                var curOverf = el.style.overflow;

                if (!curOverf || curOverf === "visible") el.style.overflow = "hidden";

                var isOverflowing =
                    el.clientWidth < el.scrollWidth || el.clientHeight < el.scrollHeight;

                el.style.overflow = curOverf;

                return isOverflowing;
            }
            ///////////////////////////////////
            //show 'no message' <p> im messages:
            //#region
            //console.log();
            if ($("p.default").siblings().length == 0) {
                $(".default").show();
            }
            //#endregion
            /////////////////
            mutations.forEach((record) => {
                // console.log(record);
                //#region get primary article
                if (record.type === "childList") {
                    record.addedNodes.forEach((el) => {
                        //console.log(el);

                        if (el.tagName == "SECTION") {
                            el.childNodes.forEach((el) => {
                                if (el.tagName == "ARTICLE") {
                                    //#endregion
                                    if (el.classList.contains("primary-article")) {
                                        //?if article is primary (contains all the section content) and has articles in it:
                                        if (el.querySelector("article")) {
                                            //console.log(el);
                                            // console.log(el.id);
                                            let ids = [];
                                            el.childNodes.forEach((e) => {
                                                if (e.tagName == "ARTICLE") {
                                                    ids.push(e.id);
                                                }
                                            });
                                            // console.log(ids);
                                            let newBtns = ids.map((id) => {
                                                let text = id.replaceAll("-", " ");
                                                return `<a href="#${id}">${text}</a>`;
                                            });
                                            newBtns = newBtns.join("");
                                            // console.log(ids);

                                            // console.log(btn);
                                            if (ids.length > 0) {
                                                openSmallNav(el, newBtns);
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    });
                }
            });
            //console.log(mutations);
        });
        var config = { childList: true };
        observer.observe(mainContainer, config);
    }
    addObserverIfDesiredNodeAvailable();

    /////////////////

    //NOTE:open small nav-func
    function openSmallNav(el, newBtns) {
        let $btn = $('a[href="#' + el.id + '"]');
        $btn.addClass("nav-slider");
        $btn.click(function() {
            $(".small").css("display", "none");
            $(".small").html(newBtns);
            if ($(this).hasClass("nav-slider")) {
                $(".nav-slider").removeClass("active-small");
                $(this).addClass("active-small");
                //set tooltip arr distance
                let $this = $(".active-small");

                if ($(".small").attr("id") == "small-mobile") {
                    $("#secondary-nav div.small").css("display", "flex");
                } else {
                    let starDistance = $this.offset().left - $this.parent().offset().left;
                    $("#secondary-nav div.small")
                        .css("padding-left", starDistance + "px")
                        .css("display", "flex");
                }
            }
        });
    }
});

$(() => {
    // //NOTE: secondary navigator click
    // $(".big a").click(function() {
    //     if (!$(this).hasClass("nav-slider")) {
    //         $(".small").css("display", "none");
    //     }
    // });
    //FIXME: do not remove .big, instead use extra 'mobile-big' class
    $("#secondary-nav>div a").click(function() {
        if (!$(this).hasClass("nav-slider")) {
            $(".small").css("display", "none");
        }
    });
});