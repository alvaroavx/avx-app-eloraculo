/*
 CHAT JS: Archivo encargado del manejo de los mensajes del chat
 elOraculo 2018 Steins
 @AlvaxVargas
*/

/* Carga el cajon completo del chat */
$.LoadChatRow = function(){
    $.ajax({
        data: $.RawData("LoadChatRow"),
        success: function (response) {
            $("#chat_row").html(response);
        }
    });
};
/* Muestra y oculta el tab de mensajes */
$.ToggleChatRow = function(mode = '') {
    let chat = $('#chat_row');
    switch (mode) {
        case 'open':
            chat.addClass('pinned')
            break;
        case 'close':
            chat.removeClass('pinned')
            break;
        case '':
        default:
            if(chat.hasClass('pinned')) {
                chat.removeClass('pinned')
            }
            else {
                chat.addClass('pinned')
            }
    }

}
/* Carga el home del chat */
$.LoadChatBody = function(){
    $.ajax({
        data: $.RawData( "LoadChatBody"),
        success: function (response) {
            $("#chattab").html(response);
        }
    });
};
/* Carga un chat en particular */
$.LoadChatTab = function(elem){
    $.ajax({
        data: $.RawData("LoadChatTab", {
            "u" : $(elem).attr("data-u")
        }),
        success: function (response) {
            $("#chattab").attr("data-u", $(elem).attr("data-u")).html(response);
        },
        complete: function(){
            /*$.ChatTabToggle(1);*/
        }
    });
};

/* Cambia el tamaño del chat */
$.MinChatTab = function(){
    var tab = $("#chat_row");
    if(tab.hasClass("minimize")){
        tab.removeClass("minimize");
        $.LoadChatBody();
    }
    else{
        tab.addClass("minimize");
    }
};

/* Elimina y aparece el menu de chat */
$.ChatTabToggle = function(bool){};

/* Contactos */
$.ContactoLoader = function(){
    $.LoadContacto($(".item_contactorow.item_queue").first());
};
$.LoadContacto = function(elem){
    if($.IsSet(elem)){
        elem.removeClass("item_queue");
        $.ContactoLoader();
        $.ajax({
            data: $.RawData("LoadContacto", {
                "u": elem.attr("data-u")
            }),
            success: function (response) {
                elem.html(response);
            }
        });
    }
};

/* Agrega un mensaje al chat */
$.AgregarMensajeChat = function(e, elem){
    if (e.key === "Enter") {
        var mensaje = $(elem).val();
        var u = $("#chattab").attr("data-u");
        if(mensaje !== ""){
            $.ajax({
                data: $.RawData("AgregarMensajeChat", {
                    "u" : u,
                    "mensaje" : mensaje
                }),
                success: function () {
                    $.LoadChatTab($("#chattab"));
                }
            });
        }
    }
};