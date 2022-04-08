const VH = Math.max(
    document.documentElement.clientHeight || 0,
    window.innerHeight || 0
);
const VW = Math.max(
    document.documentElement.clientWidth || 0,
    window.innerWidth || 0
);

//#region set max height to mobile aside
if (document.querySelector("aside")) {
    const ASIDE = document.querySelector("aside");

    let lineHeigth = getComputedStyle(document.documentElement).getPropertyValue(
        "--stripe-height"
    );
    lineHeigth = parseFloat(lineHeigth) * 3.5;
    lineHeigth = convertRemToPixels(lineHeigth);

    let h = VH - lineHeigth;
    ASIDE.style.maxHeight = h + "px";

    function convertRemToPixels(rem) {
        return (
            rem * parseFloat(getComputedStyle(document.documentElement).fontSize)
        );
    }
}
//#endregion

//#region calc nav width

const NAV_BTNS = document.getElementById("nav-btns");
const USER_NAV = document.getElementById("user");
const USER_ICO = document.getElementById("user-ico");

if (VW <= 765) {
    let as = NAV_BTNS.getElementsByTagName("a");
    for (let a of as) {
        let arr = a.innerHTML.split(" ");
        a.innerHTML = arr[1];
    }
    USER_ICO.addEventListener("click", function() {
        if (USER_ICO.classList.contains("start")) {
            USER_ICO.classList.remove("start");
            NAV_BTNS.style.display = "block";
        } else if (USER_NAV.style.display == "none") {
            NAV_BTNS.style.display = "block";
        } else {
            NAV_BTNS.style.display = "none";
        }
    });
}

//#endregion