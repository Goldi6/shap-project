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
                // console.log(result);
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

<div data-id=${obj.id} data-original='${obj.origin}'>
            <div class="box-header pad">


                <div class="save-block">
                    <button class='save-change-btn' type="submit" onclick='(function(e,obj){
                        e.preventDefault();

                        const parent = obj.parentElement.parentElement.parentElement;
                        parent.querySelector(".save-msg").style.visibility = "visible";
                        if(!parent.querySelector(".changed")){
                            
                            parent.querySelector(".save-msg").classList.add("err");
                            parent.querySelector(".save-msg").innerHTML = "nothing to save";

                        }else{
                            parent.querySelector(".save-msg").classList.remove("err");

                            var data = {};
                            data.url = document.querySelector("#url").value;

                            data["id"] = parent.getAttribute("data-id");
                            data["original_date"] = parent.getAttribute("data-original");

                            data["delete"] =  parent.querySelector(".box-footer .msgDel").value;

                            if (data.delete == 1){
                                $.ajax({
                                    data :data,
                                    url: "../back_process/messages_page/delete-msg.php",
                                    type: "POST",
                                    beforeSend: function(){
                                        parent.querySelector(".save-msg").innerHTML = "deleting...";

                                    }
                                }).then(function(resolve){
                                    console.log(resolve);
                                    if(resolve == "deleted"){
                                        //console.log("DELETED");
                                        setTimeout(function(){
                                            parent.querySelector(".save-msg").style.color ="green";
                                            parent.querySelector(".save-msg").innerHTML = "deleted!";
 
                                        },500)
                                        return true;
                                    }else return false
                                } ,function(reject){
                                    parent.querySelector(".save-msg").innerHTML = "server ERROR";

                                }).done(function(result){
                                    if(result){

                                        setTimeout(function(){
                                            parent.remove();
                                        },1000);
                                    }else{
                                        parent.querySelector(".save-msg").innerHTML = "server ERROR";

                                    }
                                })
                            }else{

                                data["frz"] =  parent.querySelector(".box-footer .msgFrz").value;
                                data["exp"] =  parent.querySelector(".box-footer .exp-date").value;
                                data["status"] = parent.querySelector(".status .get-status").textContent;
                                data["newExp"] = parent.querySelector(".status input[name=new-msg-date]").value;
                                let checkers =parent.querySelectorAll(".selectors input");
                                for(inp of checkers){
                                    data[inp.name] = Number(inp.checked);
                                   }
                            }



                            
                            console.log(data);

                           // parent.querySelector(".save-msg").innerHTML = "saving...";


                        }
                        console.log(id);
                    })(event,this)'></button>
                    <p class='save-msg'></p>
                </div>



                <div class='selectors'>
                <p class='${active_sho}' onclick='(function(obj){
                    const parent = obj.parentElement.parentElement;
                    parent.querySelector(".save-msg").style.visibility = "hidden";

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
                        const parent = obj.parentElement.parentElement;
                        parent.querySelector(".save-msg").style.visibility = "hidden";

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
                        const parent = obj.parentElement.parentElement;
                        parent.querySelector(".save-msg").style.visibility = "hidden";

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
                    const parent = obj.parentElement.parentElement;
                    parent.querySelector(".save-msg").style.visibility = "hidden";

                    obj.classList.toggle("changed");

                    obj.classList.toggle("active");
                if (obj.classList.contains("active")) {
                    obj.value ="1"; 


                    parent.classList.add("disabled");
                    parent.querySelector(".save-msg").innerHTML = "This message will be completely deleted";  
                    parent.querySelector(".save-msg").classList.remove("err");
                    
                    let pStyle = window.getComputedStyle(parent);
                    pStyle = pStyle.getPropertyValue("width");
                    pStyle = 80 * parseInt(pStyle) / 100;
                    //console.log(parseInt(pStyle));
                    parent.querySelector(".save-msg").style.width = pStyle +"px";



                     parent.querySelector("input[name=new-msg-date]").disabled=true;
                    // console.log(parent);
                } else {
                    obj.value="0";
                    parent.classList.remove("disabled");
                    parent.querySelector("input[name=new-msg-date]").disabled=false;
                    parent.querySelector(".save-msg").style.visibility = "hidden";                        

                    parent.style.filter = "brightness(100%)";
                }})(this)'>delete</button>
                <button class='exp-date' style='cursor:context-menu'
                value='${obj.expire}' disabled>

                    
                        ${obj.expire}
                    
                </button>
                <button class='msgFrz' value='0' onclick='(function(obj){
                    const parent = obj.parentElement.parentElement;
                    parent.querySelector(".save-msg").style.visibility = "hidden";

                    obj.classList.toggle("changed");

                    obj.classList.toggle("active");
                if (obj.classList.contains("active")) {
                  obj.value=1;
                }else{
                    obj.value = 0;
                }})(this)'>${frz}</button>

            </div>
            <div class="status" >
                <p>
                    Status:
                </p>
                <p style='color:${color};' class='get-status'>${obj.stat}</p>
                <p>
                    Set exp:
                    <input min="${today}" type="date" name="new-msg-date" onchange='(function(obj){
                        const parent = obj.parentElement.parentElement.parentElement;
                        parent.querySelector(".save-msg").style.visibility = "hidden";
                        
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