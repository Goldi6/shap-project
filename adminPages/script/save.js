$(() => {
    let data = {
        data: $("#richText").val(),
        page: $("#save-page").val(),
        section: $("#save-section").val(),
        filename: $("#save-filename").val(),
    };

    $.ajax({
        url: "../back_process/page_update/save.php",
        type: "json",
        data: data,
        beforeSend: function() {},
    }).done(function(data) {});
});