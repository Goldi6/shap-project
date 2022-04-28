$(document).ready(function() {
    //#region buttons
    $(" .admin-nav-btn").click(function() {
        let btn = $(this);
        const nav = btn.parent();
        let parent = btn.parents(".admin-cont-parent");
        nav.find(".admin-nav-btn").removeClass("active");
        btn.addClass("active");
        let toggle = parent.children(".toggle-display");
        for (el of toggle) {
            let dis = window.getComputedStyle(el).display;
            let b =
                dis == "none" ?
                (el.style.display = "block") :
                (el.style.display = "none");
        }
    });
    $("#forgot-pass").click(function(e) {
        e.preventDefault();
        document.location.href = "../back_process/login/pass-reset.php";
    });

    //#endregion
    $("input").keydown(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    //#region password form
    $('input[name="submit-pass-change"]').bind("keyup", function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            verifyPassword(document.forms["change-password-form"]);
        }
    });

    document.forms["change-password-form"].addEventListener(
        "submit",
        function(e) {
            e.preventDefault();
            verifyPassword(this);
        }
    );

    function verifyPassword(form) {
        form.getElementsByClassName("not-allowed")[1].style.display = "none";
        form.getElementsByClassName("not-allowed")[0].style.display = "none";

        let special = [];
        let empty = [];
        const specialChars = /[&"><\\\/ ]/;
        let match = [];
        const inputs = form.elements;
        for (i = 0; i < inputs.length; i++) {
            if (inputs[i].nodeName === "INPUT" && inputs[i].type === "password") {
                inputs[i].style.border = "#333 solid 1px";

                if (inputs[i].id == "new-pass" || inputs[i].id == "retype-new-pass") {
                    match.push(inputs[i].value);
                }
                if (inputs[i].value == "") {
                    inputs[i].style.border = "red solid 1px";
                    empty.push(false);
                } else if (specialChars.test(inputs[i].value)) {
                    inputs[i].style.border = "red solid 1px";

                    special.push(specialChars.test(inputs[i].value));
                    form.getElementsByClassName("not-allowed")[0].style.display = "block";
                }
            }
        }

        if (special.every((bl) => !bl) && empty.length == 0) {
            if (match[0] === match[1]) {
                form.submit();
            } else {
                form.getElementsByClassName("not-allowed")[1].style.display = "block";
                form.reset();
            }
        }
    }

    //#endregion

    //#region email form

    function verifyEmail(form) {
        let b = [];
        const emailValidate = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/g;
        const codeValidate = /\d{5}/;
        const inputs = form.elements;
        values = [];

        for (i = 0; i < inputs.length; i++) {
            inputs[i].style.border = "#333 solid 1px";

            if (inputs[i].nodeName === "INPUT" && inputs[i].type === "email") {
                let inpVal = inputs[i].value.trim();
                values.push(inpVal);
                if (inpVal == "") {
                    inputs[i].style.border = "red solid 1px";
                    b.push(false);
                }
                if (!emailValidate.test(inpVal)) {
                    inputs[i].style.border = "red solid 1px";

                    b.push(emailValidate.test(inpVal));
                }
            }
        }
        if (b.every((bl) => bl)) {
            if (values[0] === values[1]) {
                for (inp of inputs) {
                    if (inp.type === "email") {
                        inp.style.border = "#333 solid 1px";
                        inp.setAttribute("disabled", "");
                    }
                    if (inp.type === "text") {
                        inp.removeAttribute("disabled");
                    }
                }
                console.log("ok");
            }
        }
    }

    document.forms["change-email-form"].addEventListener("submit", function(e) {
        e.preventDefault();
        verifyEmail(this);
    });
    $('input[name="submit-email-change"]').bind("keyup", function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            verifyEmail(document.forms["change-email-form"]);
        }
    });

    //#endregion
});