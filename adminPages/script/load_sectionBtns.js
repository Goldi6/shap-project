const btnsContainer = document.querySelector("#show-all-div");
const selectBtns = document.querySelectorAll(".radio-btn-main");
for (let span of selectBtns) {
    span.addEventListener("click", () => {
        let input = span.querySelector("input").getAttribute("value");
        let pageSearch = input.substring(0, input.length - 10);

        var files;

        if (pageSearch === "shomrim") {
            files = window.files_shomrim;
        }
        if (pageSearch === "nikayon") {
            files = window.files_nikayon;
        }
        if (pageSearch === "ahzaka") {
            files = window.files_ahzaka;
        }
        if (pageSearch == "home") {
            files = window.files_home;
        }
        console.log(files);

        files = files.map((name) => {
            return `<span class="radio-btn-sub radio-btn" onclick='navClick()'>

            <input type="radio" name="section-select" value="${name}-edit" id="${name}-edit">
            <legend for="${name}-edit">${name}</legend>
        </span>`;
        });
        files = files.join("");
        btnsContainer.innerHTML = files;
        let setAttr = btnsContainer.querySelector("input");
        console.log(setAttr);
        setAttr.click();
    });
}