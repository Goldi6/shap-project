function getStyle(el, styleProp) {
    var x = document.getElementById(el);

    if (window.getComputedStyle) {
        var y = document.defaultView
            .getComputedStyle(x, null)
            .getPropertyValue(styleProp);
    } else if (x.currentStyle) {
        var y = x.currentStyle[styleProp];
    }

    return y;
}
var zInd = getStyle("small", "zIndex");
console.log(zInd);