function checkNumOrNot(num){
    if(num != ''){
        if(!isNaN(num) && num.length == 12){
            return true;
        } else if(!isNaN(num) && num.length > 12 || num.length < 12) {
            return "ИИН должен состоять из 12 чисел";
        } else {
            return "Введите корректный ИИН";
        }
    } else {
        return "Заполните поле ИИН";
    }
}

function getTextForDisplay(responce){
    let length = responce.length - 1;
    if(responce[length][1] == "1"){
        return "<div class=\"alert alert-primary\" role=\"alert\">\n" +
            "Запрос отправлен\n" +
            "</div>";
    } else if(responce[length][1] == "2"){
        return "<div class=\"alert alert-info\" role=\"alert\">\n" +
            "Запрос получен деканатом\n" +
            "</div>";
    } else if(responce[length][1] == "3"){
        return "<div class=\"alert alert-success\" role=\"alert\">\n" +
            "Запрос обработан положительно<br>\n" + `<a href="http://45.90.34.249/${responce[length][0]}.pdf">Скачать файл</a>` +
            "</div>";
    } else {
        return "<div class=\"alert alert-danger\" role=\"alert\">\n" +
            "Произошла техническая ошибка\n" +
            "</div>";
    }
}

function generateId(){
    const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    const length = 9;
    let randomStr = "";

    for (let i = 0; i < length; i++) {
        const randomNum = Math.floor(Math.random() * characters.length);
        randomStr += characters[randomNum];
    }
    return randomStr;
}

$("#status_button").click(function (){
    let user_id = document.getElementById("user_id").value;
    let enroll_id = document.getElementById("enroll").value;
    let checker = checkNumOrNot(user_id);

    if(checker == true && enroll_id != "0"){
        $.post("/php/getter.php", {post_userID: user_id, post_enrollID: enroll_id}, function (data){
            let responce = data;
            if(responce == false){
                responce = "По данному ИИН не найдено заявок";
            } else {
                responce = getTextForDisplay(JSON.parse(responce));
                console.log(responce);
            }
            document.getElementById("displayText").innerHTML = responce;
        });
    } else if (enroll_id == "0") {
        alert("Выберите тип справки");
    } else {
        alert(checker);
    }

});

$("#request_button").click(function (){
   let user_id = document.getElementById("request_user_id").value;
   let checker = checkNumOrNot(user_id);
   if(checker == true){
       $.post("/php/request_getter.php", {post_userID: user_id}, function (data){
           let responce = data;
           if(responce == false){
               alert("По данному ИИН не найдено заявок");
           } else {
               responce = JSON.parse(responce)
               document.getElementById("aboutUser").value = responce.username;
               document.getElementById("userBirthday").value = responce.birthday;
               document.getElementById("groupUser").value = responce.user_group;
           }
       })
   } else {
       alert(checker);
   }
});

$("#request_select").click(function (){
   let select_id = document.getElementById("request_select").value;
   if(select_id == "2") {
       $(".request_container").css("height", "750px");
       $("#cities").css("display", "");
       $("#draftboards").css("display", "");
       if($("#cities").children('option').length == 1){
           $.getJSON("./js/draftboards/all.json", function(data){
               for(var i = 0; i < data.items.length; i++){
                   $("#cities").append(`<option value="${data.items[i].id}">${data.items[i].nameRu}</option>`)
               }
           })
       }
   } else {
       if($("#cities").children('option').length != 1){
           $("#cities").empty();
           $("#cities").append("<option value='0' selected>Выберите город</option>")
           $("#cities").css("display", "none");
           $(".request_container").css("height", "620px");
       }
       if($("#draftboards").children('option').length != 1){
           $("#draftboards").empty();
           $("#draftboards").append("<option value='0' selected>Выберите военкомат</option>")
           $("#draftboards").css("display", "none");
       }
   }
});

$("#cities").click(function(){
    let city_id = document.getElementById("cities").value;
    if(city_id != "0" && $("#draftboards").length){
        $("#draftboards").empty();
        $("#draftboards").append("<option value='0' selected>Выберите военкомат</option>")
    }
    if(city_id != "0") {
        $.getJSON(`./js/draftboards/${city_id}.json`, function(data){
            for(var i = 0; i < data.items.length; i++){
                $("#draftboards").append(`<option value="${data.items[i].id}">${data.items[i].nameRu}</option>`)
            }
        })
    }
});


function sendRequest(){
   let user_id = document.getElementById("request_user_id").value;
   let select_id = document.getElementById("request_select").value;
   let city_id, draftBoard_id;
   if(select_id == "2"){
       city_id = document.getElementById("cities").value;
       draftBoard_id = document.getElementById("draftboards").value;
   }
   let username = document.getElementById("aboutUser").value;
   let userBirthday = document.getElementById("userBirthday").value;
   let userGroup = document.getElementById("groupUser").value;

   if(checkNumOrNot(user_id) == true && ((select_id == "2" && city_id != "0" && draftBoard_id != "0") || (select_id != "0" && select_id != "2")) && username != "" && userBirthday != "" && userGroup != ""){
       let array;
       if(select_id == "2"){
           array = {
               post_identificator: generateId(), post_userID: user_id, post_city: city_id, post_draftBoard: draftBoard_id, post_enrollID: select_id, post_status: 1
           }
       } else {
            array = {
                post_identificator: generateId(), post_userID: user_id, post_enrollID: select_id, post_status: 1
            }
       }
       $.post("/php/send_enroll.php", array, function (data){
            if(data == 1){
                alert("Введите корректный ИИН");
            }
            if(data == 2){
                alert("Вы недавно подавали заявление по данному виду справки. Пожалуйста дождитесь ответа!")
            }
            if(data == 3){
                alert("Произошла техническая ошибка");
            }
            if(data == 4){
                alert("Заявление успешно создано!");
            }
       })
   } else {
       alert("Заполните все поля или проверьте корректность данных");
   }
   return false;
};