$(document).ready(function() {
    //#region buttons
    $(" .admin-nav-btn").click(function() {
        let btn = $(this);
        let data = btn.attr("id");
        let formId = data.split("-")[0] + "-" + data.split("-")[1] + "-form";
        const nav = btn.parent();
        let parent = btn.parents(".admin-cont-parent");
        nav.find(".admin-nav-btn").removeClass("active");
        btn.addClass("active");

        let toggle = parent.children(".toggle-display");
        for (el of toggle) {
            if (el.id == formId) {
                el.style.display = "grid";
            } else {
                el.style.display = "none";
            }
        }
    });
    $("#forgot-pass").click(function(e) {
        e.preventDefault();
        document.location.href = "../back_process/login/pass-reset.php";
    });

    //#endregion
    $(
        "#create-user-form input,#change-email-form input,#change-password input"
    ).keydown(function(event) {
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
        if (form.getAttribute("data-token") > 1) {
            return "ready";
        } else {
            window.breakTimer = "";

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
                    $.ajax({
                            data: {
                                setEmail: values[0],
                                againEmail: values[1],
                                url: $("#url").val(),
                            },
                            method: "post",
                            url: "../back_process/admin/generate_token.php",
                        })
                        .done(function(data) {
                            data = JSON.parse(data);
                            if (data.result === "generated") {
                                // console.log(data.temp_email);
                                //  console.log(data.stamp);
                                window.id_to_timer = "emailSet-stamp";
                                window.time_to_timer = data.stamp;
                                window.inputs = inputs;
                                window.form = form;
                                window.email_token = data.email_token;
                                $.getScript("../script/timer.js");
                                $.getScript("../script/Admin_set_email_values.js");

                                return "verified";
                            } else if (data.result === "fail") {
                                $("#emailSet-error").text(data.error).show();
                                return "error";
                            }
                        })
                        .fail(function() {
                            $("emailSet-error").text("connection error").show();
                        });
                }
            }
        }
    }

    document.forms["change-email-form"].addEventListener("submit", function(e) {
        e.preventDefault();
        let b = verifyEmail(this);
        //console.log(b);
        if (b == "ready" && this.getAttribute("data-token")) {
            if (
                this.elements["repeat-email"].value !== "" &&
                this.elements["new-email"].value !== "" &&
                /\d{6}/.test(this.elements["verify-code"].value)
            ) {
                emailAjaxSubmit(this);
            } else {
                $("#emailSet-error").text("* please input verification code").show();
            }
        }
    });
    $('input[name="submit-email-change"]').bind("keyup", function(e) {
        if (e.keyCode === 13) {
            e.preventDefault();
            let b = verifyEmail(document.forms["change-email-form"]);
            //console.log(b);
            if (
                b == "ready" &&
                document.forms["change-email-form"].getAttribute("data-token")
            ) {
                if (
                    document.forms["change-email-form"].elements["repeat-email"].value !==
                    "" &&
                    document.forms["change-email-form"].elements["new-email"].value !==
                    "" &&
                    /\d{6}/.test(this.elements["verify-code"].value)
                ) {
                    emailAjaxSubmit(document.forms["change-email-form"]);
                } else {
                    $("#emailSet-error").text("* input verification code").show();
                }
            }
        }
    });

    function emailAjaxSubmit(form) {
        let email1 = form.elements["new-email"].value;
        let email2 = form.elements["repeat-email"].value;
        let code = form.elements["verify-code"].value;
        let url = form.elements["url"].value;

        if (email1 === email2) {
            let email = email1;
            $.ajax({
                    method: "post",
                    url: "../back_process/admin/email-change.php",
                    data: { "new-email": email, url: url, "verify-code": code },
                    beforeSend: function() {
                        form.elements["verify-code"].setAttribute("disabled", "");
                    },
                })
                .done(function(data) {
                    let obj = JSON.parse(data);
                    console.log(data);
                    if (obj.result === "updated") {
                        $("#emailSet-error").hide();
                        window.breakTimer = "break";
                        setTimeout(function() {
                            $("#emailSet-stamp").text("email updated to " + obj.email + "!");
                            $("#user-data-content span:nth-child(3)").text(obj.email);
                        }, 1000);
                        form.removeAttribute("data-token");
                        setTimeout(function() {
                            form.reset();
                            for (let inp of form.elements) {
                                if (inp.type === "email") {
                                    inp.removeAttribute("disabled");
                                }
                            }
                        }, 1000);
                    } else if (obj.result === "fail") {
                        $("#emailSet-error").text(obj.error).show();
                        setTimeout(function() {
                            form.elements["verify-code"].removeAttribute("disabled");
                            form.elements["verify-code"].value = "";
                        }, 700);
                    }
                })
                .fail(function() {
                    $("#emailSet-error").text("connection error").show();
                    setTimeout(function() {
                        form.elements["verify-code"].removeAttribute("disabled");
                    }, 700);
                });
        }
    }
    //#endregion
});