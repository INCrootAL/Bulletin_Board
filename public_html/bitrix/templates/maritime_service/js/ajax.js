
function addFavorite(id, action, namesClass, txtClassName) {
    var param = 'id='+id+"&action="+action;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/favorites.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) { // Если Данные отправлены успешно
            var result = $.parseJSON(response);
            if(result == 1){
                //alert(txtClassName)
                if (document.querySelector(txtClassName).textContent == "Добавить в избранное") { 
                    document.querySelector('.product-item-properties-comp-detail-wishes').textContent = "Добавлено в избранное"
                }
                 $(namesClass + '[data-item="'+id+'"]').addClass('active');
            }
            if(result == 2){
                if (document.querySelector(txtClassName).textContent == "Добавлено в избранное") { 
                    document.querySelector('.product-item-properties-comp-detail-wishes.active').textContent = "Добавить в избранное"
                }
                 $(namesClass + '[data-item="'+id+'"]').removeClass('active');
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}

function SubmitResponses(idUser, idResume) {
    var param = 'idUser='+idUser+"&idResume="+idResume;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/responses.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) { // Если Данные отправлены успешно
            var result = $.parseJSON(response);
            if (result == 1) {
                let popup_war = document.getElementById("popup_war");
	            popup_war.classList.add('active');
	            popup_war.style.height = "63px";
	            popup_war.style.width = "416px";
	            $('#popup_wrapper').addClass('active');
    	            let aldInnerW = '<a class="for_info_war_svg"><svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'+'<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'+'<path d="M10.5 6.75298V10.9752M10.5526 14.1419V14.2474L10.4474 14.247V14.1419H10.5526ZM1 16.6224V4.37798C1 3.19565 1 2.60404 1.2301 2.15245C1.4325 1.75522 1.75522 1.4325 2.15245 1.2301C2.60404 1 3.19565 1 4.37798 1H16.6224C17.8048 1 18.3951 1 18.8467 1.2301C19.2439 1.4325 19.5677 1.75522 19.7701 2.15245C20 2.6036 20 3.19449 20 4.37452V16.626C20 17.806 20 18.3961 19.7701 18.8472C19.5677 19.2444 19.2439 19.5677 18.8467 19.7701C18.3955 20 17.8055 20 16.6255 20H4.37452C3.19449 20 2.6036 20 2.15245 19.7701C1.75522 19.5677 1.4325 19.2444 1.2301 18.8472C1 18.3956 1 17.8048 1 16.6224Z" stroke="#A60303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>'+'</svg></svg></a>';
    	            document.getElementById("for_info_war").innerHTML = aldInnerW+"Ваше резюме успешной отправлено"
            }
            //Позиция отправлялась уже организации на просмотр
            if (result == 2) {
                let popup_war = document.getElementById("popup_war");
	            popup_war.classList.add('active');
	            popup_war.style.height = "63px";
	            popup_war.style.width = "625px";
	            document.getElementById("for_info_war").style.display = "flex";
	            $('#popup_wrapper').addClass('active');
    	            let aldInnerW = '<a class="for_info_war_svg"><svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'+'<svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">'+'<path d="M10.5 6.75298V10.9752M10.5526 14.1419V14.2474L10.4474 14.247V14.1419H10.5526ZM1 16.6224V4.37798C1 3.19565 1 2.60404 1.2301 2.15245C1.4325 1.75522 1.75522 1.4325 2.15245 1.2301C2.60404 1 3.19565 1 4.37798 1H16.6224C17.8048 1 18.3951 1 18.8467 1.2301C19.2439 1.4325 19.5677 1.75522 19.7701 2.15245C20 2.6036 20 3.19449 20 4.37452V16.626C20 17.806 20 18.3961 19.7701 18.8472C19.5677 19.2444 19.2439 19.5677 18.8467 19.7701C18.3955 20 17.8055 20 16.6255 20H4.37452C3.19449 20 2.6036 20 2.15245 19.7701C1.75522 19.5677 1.4325 19.2444 1.2301 18.8472C1 18.3956 1 17.8048 1 16.6224Z" stroke="#A60303" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>'+'</svg></svg></a>';
    	            document.getElementById("for_info_war").innerHTML = aldInnerW+"Вы уже направляли свое резюме для данной компании, ожидайте обратной связи"
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}

function SubmitResponsesDel(idResume) {
    var param = 'idResume='+idResume;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/responsesDel.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) {
            var result = $.parseJSON(response);
            if (result == 1) {
                location.reload()
            }
            if (result == 2) {
                console.log("Произошла ошибка на сервере №Aj-del-1")
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}

function delVac(delID) {
    var param = 'id='+delID;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/deleteVacancies.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) { // Если Данные отправлены успешно
            var result = $.parseJSON(response);
            if(result == 1) {
                //alert(txtClassName)
                let newcontinuet = document.querySelector("#popup-lk-delete-info-button-yes");
                newcontinuet.removeAttribute('data-id')
                $('#popup-lk').removeClass("active")
                $("#popup-lk-delete").removeClass("active");
                location.reload()
            }
            if(result == 2) {
                alert("При удалении произошла ошибка, пожалуйста, повторите удаление.")
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}

function delRes(delResID) {
    var param = 'id='+delResID;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/deleteResume.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) { // Если Данные отправлены успешно
            var result = $.parseJSON(response);
            //alert(result)
            if (result == 1) {
                let newcontinuet = document.querySelector("#popup-lk-delete-info-button-yes");
                newcontinuet.removeAttribute('data-id')
                $('#popup-lk').removeClass("active")
                $("#popup-lk-delete").removeClass("active");
                location.reload()
            }
            if (result == 2) {
                alert("При удалении произошла ошибка, пожалуйста, повторите удаление.")
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}

function AddGeneral(typeJS, pubIDJS, viewJS, overjs) {
    var param = 'typeJS='+typeJS+"&pubIDJS="+pubIDJS+"&viewJS="+viewJS+"&overjs="+overjs;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/genereralADM.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) {
            var result = $.parseJSON(response);
            if (result == 1) {
                //alert("Walpleade")
                location.reload()
            } else {
                alert(result)
            }
            if (result == 2) {
                alert("Error #32")
                //console.log("Произошла ошибка на сервере №Aj-del-1")
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
    });
}

function editPhoto(usIDJS, usPhotoJS) {
    var param = 'usIDJS='+usIDJS+"&usPhotoJS="+usPhotoJS;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/editPhoto.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) {
            var result = $.parseJSON(response);
            if (result == 1) {
                //alert("Успешно")
                //location.reload()
            } else {
                console.log(result)
            }
            if (result == 2) {
                alert("Error #32")
                //console.log("Произошла ошибка на сервере №Aj-del-1")
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}


function repeatApplication(pubID_US_JS, typeBlockJS) {
    var param = 'pubID_US_JS='+pubID_US_JS+"&typeBlockJS="+typeBlockJS;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/repeatApplication.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) {
            var result = $.parseJSON(response);
            if (result == 1) {
                //alert("Успешно")
                location.reload()
            } else {
                console.log(result)
            }
            if (result == 2) {
                alert("Error #358")
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}

function admDelandNot(_par, _parType, _view) {
    var param = '_par='+_par+"&_parType="+_parType+"&_view="+_view;
    $.ajax({
        url:     '/bitrix/templates/maritime_service/php/admDelandNot.php', // URL отправки запроса
        type:     "GET",
        dataType: "html",
        data: param,
        success: function(response) {
            var result = $.parseJSON(response);
            if (result == 1) {
            } else  if (result == 2) {
                alert("Error #358")
            } else {
                console.log(result)
            }
        },
        error: function(jqXHR, textStatus, errorThrown){
            console.log('Error: '+ errorThrown);
        }
     });
}