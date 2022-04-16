$(() => {
    //#region set values after false submit
    //NOTE:load current expire date after error
    if ($("#hidden-expire")) {
        let exDate = new Date($("#hidden-expire").text());
        exDate.setDate(exDate.getDate() + 1);
        document.getElementById("expire-msg").valueAsDate = exDate;
    }
    //NOTE:load current msg content after error
    if ($("#hidden-msg")) {
        $("#richText").val($("#hidden-msg").html()).trigger("change");
    }
    //NOTE:load current selection content after error
    if ($("#hidden-select")) {
        function checkBool(num) {
            return num == 1;
        }
        let $val = $("#hidden-select").text();
        const $vala = $val.trim().split("");

        const sho = $vala[0],
            ahz = $vala[1],
            nik = $vala[2];

        $("#shomrim-msg").prop("checked", checkBool(sho));
        $("#nikayon-msg").prop("checked", checkBool(nik));

        $("#ahzaka-msg").prop("checked", checkBool(ahz));
    }
    //#endregion
});