$(() => {
    $("#load-msg").click(function() {
        $shoVal = $("#shomrim-msg-load").is(":checked") ? 1 : 0;
        $nikVal = $("#nikayon-msg-load").is(":checked") ? 1 : 0;
        $ahzVal = $("#ahzaka-msg-load").is(":checked") ? 1 : 0;
        $url = $("#url").val();

        $.ajax({
            data: { nik: $nikVal, sho: $shoVal, ahz: $ahzVal },
            type: "POST",
            url: "../back_process/messages_page/get-messages.php",
            success: function(result) {
                console.log(result);
                if (result != 0) {
                    let data = JSON.parse(result);
                    let elements = data.map((obj) => {
                        var frz = obj.stat == "active" ? "freeze" : "unfreeze";

                        if (obj.expire === "0000-00-00") {
                            obj.expire = "Fixed";
                        } else {
                            obj.expire = new Date(obj.expire);
                            const today = new Date("yyyy-mm-dd");

                            if (today > obj.expire) obj.stat = "expired";

                            let day = obj.expire.getDate();
                            let mo = obj.expire.getMonth() + 1;
                            let y = obj.expire.getFullYear();
                            obj.expire = "exp: " + day + "." + mo + "." + y;
                        }

                        let color =
                            obj.stat == "frozen" ?
                            "cyan" :
                            obj.stat == "active" ?
                            "greenyellow" :
                            "grey";

                        return elem(obj, frz, color);
                    });
                    elements = elements.join("");
                    $("#active-messages").html(elements);
                } else {
                    $("#active-messages").html("");
                }
                //console.log(elements);
            },
            error: function() {},
        });
    });
});

const elem = function(obj, frz, color) {
    return `

<div data-id=${obj.id}>
            <div class="box-header pad">


                <button class='save-change-btn' type="submit"></button>



                <div>
                <span class='in-messages' >
                <input type="checkbox" name="sho-check" checked=${Boolean(
                  obj.sho
                )} >
                        שומרים
                    </span>
                    <span class='in-messages' >
                    <input type="checkbox" name="ahz-check" checked=${Boolean(
                      obj.ahz
                    )}>
                        אחזקה
                    </span>
                    <span class='in-messages' >
                    <input type="checkbox" name="nik-check" checked=${Boolean(
                      obj.nik
                    )}>
                        ניקיון
                    </span>
                </div>


            </div>
            <div class="message-cont">
${obj.msg}
            </div>
            <div class="box-footer">
                <button>delete</button>
                <button class='exp-date'>

                    
                        ${obj.expire}
                    
                </button>
                <button>${frz}</button>

            </div>
            <div class="status">
                <p>
                    Status:
                </p>
                <p style='color:${color};'>${obj.stat}</p>
                <p>
                    New exp:
                    <input type="date" name="new-msg-date" id="">
                </p>
            </div>
        </div>



`;
};