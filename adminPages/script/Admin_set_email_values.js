for (inp of inputs) {
    if (inp.type === "email") {
        inp.style.border = "#333 solid 1px";
        inp.setAttribute("disabled", "");
    }
    if (inp.type === "text") {
        inp.removeAttribute("disabled");
    }
}
form.setAttribute("name", "change-email-form-verify");
form.setAttribute("data-token", email_token);