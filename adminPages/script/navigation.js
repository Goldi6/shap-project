$(document).ready(() => {
    $(".nav-btn").removeAttr("id");
    let path = window.location.pathname;
    (path = path.split("/")),
    (path = path[path.length - 1]),
    (path = path.split(".")),
    (path = path[0]);

    const navBtn = document.getElementsByClassName("nav-btn");
    for (let i = 0; i < navBtn.length; i++) {
        if (navBtn[i].value == path) {
            navBtn[i].setAttribute("id", "active");
        }
    }
});