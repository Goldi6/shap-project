////////////////////////////////
const subRadio = document.getElementsByClassName("radio-btn-sub");
const mainRadio = document.getElementsByClassName("radio-btn-main");
const msgRadio = document.getElementsByClassName("check-btn-msg");

const subSelectForSections = document.querySelector("#show-all-div");

//styleBtns(subRadio);
styleBtns(mainRadio);
check(msgRadio);
check(subRadio);
//check(mainRadio);

function check(spans) {
    for (let span of spans) {
        let inp = span.previousSibling.previousSibling;
        span.addEventListener("click", function() {
            //console.log(inp);
            inp.checked ^= 1;
        });
    }
}

function styleBtns(select) {
    //for each span[container] of the input
    for (let span of select) {
        let inp = span.previousSibling.previousSibling;
        //console.log(inp);

        if (inp.getAttribute("name") === "page-select") {
            if (
                inp.getAttribute("value") == "home-cont_edit" &&
                inp.checked == true
            ) {
                //subSelectForSections.style.display = "none";
                //?in page edit sub selection handle (select main section and hide sections related to other pages)
                selectMainSubBtn();
            } else {
                subSelectForSections.style.display = "flex";
                DEselectMainSubBtn();
            }
        }
        span.addEventListener("click", () => {
            //set style
            inp.checked = true;
            if (inp.checked == true) {
                ////////////////////////

                if (inp.getAttribute("name") === "page-select") {
                    if (inp.getAttribute("value") == "home-cont_edit") {
                        // subSelectForSections.style.display = "none";
                        selectMainSubBtn();
                    } else {
                        subSelectForSections.style.display = "flex";
                        DEselectMainSubBtn();
                    }
                }

                /////////////////////////
            }
            let a = document.getElementById("main-edit").checked;
            console.log(a);
        });
    }
}
//////////////////////////////
//checkbox in main form -creating backup file
$("#backup-check").change(() => {
    if ($("#backup-check").is(":checked")) {
        $("#create-backup-div>input[type='text']").addClass("active");
        $("#create-backup-div>input[type='text']").removeAttr("disabled");
    } else {
        $("#create-backup-div>input[type='text']").removeClass("active");
        $("#create-backup-div>input[type='text']").attr("disabled", true);
    }
});

function selectMainSubBtn() {
    let btnMain = document.querySelector("#main-subNav-btn");
    btnMain.style.display = "flex";

    selectInput(btnMain).checked = true;
    for (sub of subRadio) {
        if (sub.id != "main-subNav-btn") {
            sub.style.display = "none";
        }
    }
    btnMain.addEventListener("click", () => {
        selectInput(btnMain).checked = true;
    });
}

function DEselectMainSubBtn() {
    for (sub of subRadio) {
        if (sub.id == "main-subNav-btn") {
            sub.style.display = "none";
        } else {
            sub.style.display = "flex";
        }
    }
    let first = subRadio[0];
    checkFirst(first);
}

function checkFirst(el) {
    let inp = selectInput(el);
    inp.checked = true;
}

function selectInput(el) {
    return el.previousSibling.previousSibling;
}