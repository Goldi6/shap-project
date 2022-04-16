$(() => {
    //#region set values after false submit
    //NOTE:load current text content after error
    if ($("#hidden-text")) {
        $("#richText").val($("#hidden-text").html()).trigger("change");
    }

    //NOTE:set checkbox and filename
    if ($("#hidden-backup_content")) {
        $("input[name=backup-content]").prop("checked", 1);
        $("input[name=backup-name]").removeAttr("disabled").addClass("active");

        //FIXME session not setting
        if ($("#hidden-backup_name")) {
            let val = $("#hidden-backup_name").text();
            $("input[name=backup-name]").val(val);
        }
    }

    //NOTE:set radio page
    if ($("#hidden-page")) {
        let val = $("#hidden-page").text();

        $("input[name=page-select][value='" + val + "']")
            .next()
            .click();
    }
    //NOTE:set radio section

    if ($("#hidden-section")) {
        let val = $("#hidden-section").text();
        $("input[name=section-select][value='" + val + "']")
            .next()
            .click();
    }

    //NOTE:set radio create/add
    if ($("#hidden-create_add")) {
        let val = $("#hidden-create_add").text();
        $("input[name=create_or_add][value='" + val + "']").prop("checked", true);
    }

    //#endregion
});