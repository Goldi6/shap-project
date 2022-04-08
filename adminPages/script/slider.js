//NOTE: page editor aside script
$(() => {
    //slide
    $("#slider").click(() => {
        if (!$("#slider").hasClass("active")) {
            $("aside").animate({
                    left: 0,
                },
                500,
                () => {
                    $("#slider").addClass("active");
                }
            );
        } else {
            $("aside").animate({
                    left: "-16rem",
                },
                500,
                () => {
                    $("#slider").removeClass("active");
                }
            );
        }
    });
    //////////////////////////////////////
    //NOTE: content load into aside form
    //#region
    $("aside div:first-of-type button").click(function(e) {
        $("aside div:first-of-type button").removeClass("active");
        $(this).addClass("active");
        loadBackupListFull();
        ///////////////

        $("#side-section-filter button").removeClass("active");
        $("#side-section-filter button:first-of-type").addClass("active");
        /////////////////
        //block non relevant sections
        disableIrrelevant();
    });

    // filtering files
    $("#side-section-filter button").click(function() {
        $("#side-section-filter button").removeClass("active");
        $(this).addClass("active");
        loadBackupListFiltered();
    });

    loadBackupListFull();
    disableIrrelevant();
    //#endregion
    /////////////////////////////////////////
    /////////////////////////////////////
    ///////////////////////////
    //NOTE: backup files load funcs
    //#region
    function loadBackupListFull(files = getAllFiles()) {
        map_elems(files);
    }

    //?

    function loadBackupListFiltered(files = getAllFiles()) {
        files = filterFiles(files);
        map_elems(files);
    }

    //?

    function getAllFiles(page = getPage()) {
        let files;

        return window.window["backup_" + page];
    }

    function filterFiles(files, filter = getFilter()) {
        let regex = new RegExp(filter);
        return files.filter((file) => {
            return regex.test(file);
        });
    }

    /////////////////
    /////////////

    function map_elems(files) {
        if (files.length > 0) {
            files = files.map((file) => {
                return `<span onClick="(function(e, obj){let allRadio = document.querySelector('.radio-load-btns').querySelectorAll('span'); for(let btn of allRadio){btn.classList.remove('active');}; obj.classList.add('active');let inp=obj.querySelector('input').checked=true;})(arguments[0],this);"><label for='select-load'>${file}</label><input value='${file}' type='radio' name='select-load'></span>`;
            });
            $("#select-backup-load-btn").removeClass("disabled");
        } else {
            files = "<p>אין קבצים שמורים</p>";
            $("#select-backup-load-btn").addClass("disabled");
        }
        $("aside form").html(files);
    }

    function getPage() {
        let page = document
            .getElementById("side-page-select")
            .getElementsByClassName("active");
        return page[0].value;
    }

    function getFilter() {
        let filter = document
            .getElementById("side-section-filter")
            .getElementsByClassName("active");
        return filter[0].value;
    }
    //FIXME: make dinamic
    function disableIrrelevant(page = getPage()) {
        let buttons = document
            .getElementById("side-section-filter")
            .getElementsByTagName("button");
        if (page == "home") {
            for (let btn of buttons) {
                if (
                    btn.value == "nehalim" ||
                    btn.value == "schedule" ||
                    btn.value == "anhayot"
                ) {
                    btn.classList.add("disabled");
                } else {
                    btn.classList.remove("disabled");
                }
            }
        } else {
            for (let btn of buttons) {
                if (btn.value == "main") {
                    btn.classList.add("disabled");
                } else {
                    btn.classList.remove("disabled");
                }
            }
        }
    }
    //#endregion

    ///////////////////////////////////////
    ///////////////////////////
    /////////////////////////
});

/////////////////////
/////////////////////
//////////////////