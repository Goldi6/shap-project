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
                        //////////////////
                        let active_ahz =
                            obj.ahz == 1 ? "in-messages active" : "in-messages";
                        let active_nik =
                            obj.nik == 1 ? "in-messages active" : "in-messages";

                        let active_sho =
                            obj.sho == 1 ? "in-messages active" : "in-messages";

                        //////////////
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

                        return elem(
                            obj,
                            frz,
                            color,
                            active_sho,
                            active_ahz,
                            active_nik,
                            today
                        );
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

const elem = function(
    obj,
    frz,
    color,
    active_sho,
    active_ahz,
    active_nik,
    today
) {
    return `

<div data-id=${obj.id}>
            <div class="box-header pad">


                <div class="save-block">
                    <button class='save-change-btn' type="submit" onclick='(function(e,obj){
                        e.preventDefault();

                        const parent = obj.parentElement.parentElement.parentElement;
                        const id = parent.getAttribute("data-id");
                        parent.querySelector(".save-msg").style.visibility = "visible";
                        if(!parent.querySelector(".changed")){
                            parent.querySelector(".save-msg").classList.add("err");
                            parent.querySelector(".save-msg").innerHTML = "nothing to save";
                        }else{
                            parent.querySelector(".save-msg").classList.remove("err");
                            parent.querySelector(".save-msg").innerHTML = "saving...";

                            let selectors = parent.querySelector(".selectors");

                        }
                        console.log(id);
                    })(event,this)'></button>
                    <p class='save-msg'></p>
                </div>



                <div class='selectors'>
                <p class='${active_sho}' onclick='(function(obj){
                    obj.classList.toggle("changed");

                    obj.classList.toggle("active");
                    let inp =obj.firstElementChild;
                  if(obj.classList.contains("active")){
                      inp.checked=true;
                  }else{
                    inp.checked=false;
                  }
                    
            })(this)'>
                <input type="checkbox" name="sho-check" checked=${Boolean(
                  obj.sho
                )} >
                        שומרים
                    </p>
                    <p class='${active_ahz}' onclick='(function(obj){
                        obj.classList.toggle("changed");

                        obj.classList.toggle("active");
                        let inp =obj.firstElementChild;
                      if(obj.classList.contains("active")){
                          inp.checked=true;
                      }else{
                        inp.checked=false;
                      }
                        
                })(this)'>
                    <input type="checkbox" name="ahz-check" checked=${Boolean(
                      obj.ahz
                    )}>
                        אחזקה
                    </p>
                    <p class='${active_nik}' onclick='(function(obj){
                        obj.classList.toggle("changed");

                        obj.classList.toggle("active");
                        let inp =obj.firstElementChild;
                      if(obj.classList.contains("active")){
                          inp.checked=true;
                      }else{
                        inp.checked=false;
                      }
                        
                })(this)'>
                    <input type="checkbox" name="nik-check" checked=${Boolean(
                      obj.nik
                    )}>
                        ניקיון
                    </p>
                </div>


            </div>
            <div class="message-cont">
${obj.msg}
            </div>
            <div class="box-footer">
                <button value='0' class='msgDel' onclick='(function(obj){ 
                    obj.classList.toggle("changed");

                    obj.classList.toggle("active");
                if (obj.classList.contains("active")) {
                    obj.value ="1";
                } else {
                    obj.value="0";
                }})(this)'>delete</button>
                <button class='exp-date' style='cursor:context-menu' disabled>

                    
                        ${obj.expire}
                    
                </button>
                <button class='msgFrz' value='${frz}' onclick='(function(obj){
                    obj.classList.toggle("changed");

                    obj.classList.toggle("active");
                if (obj.classList.contains("active")) {
                  
                }})(this)'>${frz}</button>

            </div>
            <div class="status" >
                <p>
                    Status:
                </p>
                <p style='color:${color};'>${obj.stat}</p>
                <p>
                    Set exp:
                    <input min="${today}" type="date" name="new-msg-date" onchange='(function(obj){
                        if(obj.value==""){
                            obj.classList.remove("changed");

                        }else{
                            obj.classList.add("changed");

                        }
                    })(this)'>
                </p>
            </div>
        </div>



`;
};