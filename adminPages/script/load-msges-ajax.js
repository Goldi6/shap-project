$(() => {
    $("#load-msg").click(function() {
        $shoVal = $("#shomrim-msg-load").is(":checked") ? 1 : 0;
        $nikVal = $("#nikayon-msg-load").is(":checked") ? 1 : 0;
        $ahzVal = $("#ahzaka-msg-load").is(":checked") ? 1 : 0;
        $emptyVal = $("#empty-msg-load").is(":checked") ? 1 : 0;

        $url = $("#url").val();

        $.ajax({
            data: {
                nik: $nikVal,
                sho: $shoVal,
                ahz: $ahzVal,
                empty: $emptyVal,
                url: $url,
            },
            type: "POST",
            url: "../back_process/messages_page/get-messages.php",
            success: function(result) {
                console.log(result);
                if (result != 0) {
                    let data = JSON.parse(result);
                    let elements = data.map((obj) => {
                        //////////////////
                        const objConf = setUpValues(obj);

                        return elem(
                            obj,
                            objConf.frz,
                            objConf.color,
                            objConf.sho,
                            objConf.ahz,
                            objConf.nik,
                            objConf.today,
                            objConf.expire,
                            objConf.stat
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

function setUpValues(obj) {
    let active_ahz = obj.ahz == 1 ? "in-messages active" : "in-messages";
    let active_nik = obj.nik == 1 ? "in-messages active" : "in-messages";

    let active_sho = obj.sho == 1 ? "in-messages active" : "in-messages";

    //////////////
    let expire = "";
    if (obj.expire === "0000-00-00") {
        expire = "Fixed";
    } else {
        console.log(obj.expire);
        expire = new Date(obj.expire + "T00:00");
        const today = new Date().setHours(0, 0, 0, 0);

        //console.log(expire + " " + today);
        //console.log(expire < today);

        if (today > expire) {
            obj.stat = "expired";
        }

        let day = expire.getDate();
        let mo = expire.getMonth() + 1;
        let y = expire.getFullYear();
        expire = "exp: " + day + "." + mo + "." + y;
    }
    var frz = obj.stat == "active" ? "freeze" : "unfreeze";

    let color =
        obj.stat == "frozen" ?
        "cyan" :
        obj.stat == "active" ?
        "greenyellow" :
        "grey";

    return {
        color: color,
        frz: frz,
        expire: expire,
        today: today,
        ahz: active_ahz,
        nik: active_nik,
        sho: active_sho,
        stat: obj.stat,
    };
}

const elem = function(
    obj,
    frz,
    color,
    active_sho,
    active_ahz,
    active_nik,
    today,
    expire,
    stat
) {
    return `

<div data-id=${obj.id} data-original='${obj.origin}'>
            <div class="box-header pad">


                <div class="save-block">
                    <button class='save-change-btn' type="submit" onclick='(function(e,obj){
                        //e.preventDefault();

                        const parent = obj.parentElement.parentElement.parentElement;
                        parent.querySelector(".save-msg").style.visibility = "visible";
                        if(!parent.querySelector(".changed")){
                            parent.querySelector(".save-msg").style.color="red";
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
 
                                        },500);
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
                                let setExp = parent.querySelector(".status input[name=set-new-msg-date]").checked;
                                if(setExp){

                                    data["newExp"] = parent.querySelector(".status input[name=new-msg-date]").value;
                                }else{
                                    data["newExp"] = "";
                                }

                                data["frz"] =  parent.querySelector(".box-footer .msgFrz").value;
                                data["exp"] =  parent.querySelector(".box-footer .exp-date").value;
                                data["status"] = parent.querySelector(".status .get-status").textContent;
                                let checkers =parent.querySelectorAll(".selectors input");
                                for(inp of checkers){
                                    let name = inp.name.split("-");
                                    data[name[0]] = String(Number(inp.checked));
                                   }

                                   $.ajax({
                                    data :data,
                                    url: "../back_process/messages_page/update-msg.php",
                                    type: "POST",
                                    beforeSend: function(){
                                       // console.log(data);
                                        parent.querySelector(".save-msg").innerHTML = "updating...";
                                        parent.querySelector(".save-msg").style.color = "white";

                                    }
                                }).then(function(resolve){
                                    console.log(resolve);
                                    let obj = JSON.parse(resolve);
                                    if(obj.result == "updated"){
                                        
                                        const objReady = setUpValues(obj);
                                        parent.querySelector(".exp-date").innerHTML = objReady.expire;
                                        if(parent.querySelector(".msgFrz").classList.contains("active")){
                                            parent.querySelector(".msgFrz").innerHTML = objReady.frz;
                                            parent.querySelector(".msgFrz").classList.remove("active");
                                            parent.querySelector(".msgFrz").value = 0;
                                        }
                                        parent.querySelector(".get-status").style.color = objReady.color;
                                        parent.querySelector(".get-status").innerHTML = objReady.stat;
                                        parent.querySelector("input[name=new-msg-date]").setAttribute("min" , objReady.today);


                                        let changed = parent.querySelectorAll(".changed");
                                        for(el of changed){
                                             el.classList.remove("changed");
                                         }
                                        return true;
                                    }else {
                                        
                                        console.log("eeeee");
                                        
                                        return false};
                                } ,function(reject){
                                    parent.querySelector(".save-msg").innerHTML = "server ERROR-rejected";

                                 }).done(function(result){
                                    if(result){
                                      
                                        
                                        setTimeout(function(){
                                            parent.querySelector(".save-msg").style.color ="yellow";
                                            parent.querySelector(".save-msg").innerHTML = "Updated";

                                        },500);
                                        setTimeout(function(){
                                            parent.querySelector(".save-msg").classList.add("fadeOut");
                                            },500 );
                                            setTimeout(function(){
                                                parent.querySelector(".save-msg").style.visibility = "hidden";

                                                parent.querySelector(".save-msg").classList.remove("fadeOut");
                                                },1500 );
                                                    
                                      }else{
                                          parent.querySelector(".save-msg").innerHTML = "server ERROR";

                                      }
                                  })
                            }



                            

                           // parent.querySelector(".save-msg").innerHTML = "saving...";


                        }
                        console.log(id);
                    })(event,this)'></button>
                    <p class='save-msg'></p>
                    <p class='del-msg'>This message will be completely deleted</p>

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
                    parent.querySelector(".del-msg").style.display="block";
                    
                    let pStyle = window.getComputedStyle(parent);
                    pStyle = pStyle.getPropertyValue("width");
                    pStyle = 80 * parseInt(pStyle) / 100;
                    //console.log(parseInt(pStyle));
                    parent.querySelector(".del-msg").style.width = pStyle +"px";



                     parent.querySelector("input[name=new-msg-date]").disabled=true;
                    // console.log(parent);
                } else {
                    obj.value="0";
                    parent.classList.remove("disabled");
                    parent.querySelector("input[name=new-msg-date]").disabled=false;
                    parent.querySelector(".del-msg").style.display="none";


                    parent.style.filter = "brightness(100%)";
                }})(this)'>delete</button>

                <button class='exp-date' style='cursor:context-menu'
                value='${obj.expire}' disabled>

                    
                        ${expire}
                    
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
                <p style='color:${color};' class='get-status'>${stat}</p>
                <p>
                <input type="checkbox" name="set-new-msg-date" style="display:initial;" onchange='(function(obj){
                    if(obj.checked==true){
                        obj.nextElementSibling.style.display = "initial";
                    }else{
                        obj.nextElementSibling.style.display = "none";
                    }
                    console.log(obj.nextElementSibling.value);
                })(this)'>
                    Set exp
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