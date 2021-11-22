/**
 * DASHBOARD JS
 * Archivo encargado de las vistas dentro de la aplicacion, como panel de control
*/

/**
 *	Carga pagina inicial 
 */
$.LoadDashboard = function(){
    $.FootPrint("repositorio");
    $.ajax({
        data: $.RawData("LoadDashboard"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.GoUp($("#midblock"), 0);
            if($("#rightcol").hasClass("pinned")) {
                $.ToggleRightCol();
            }
            $.ToggleLoading("close");
        }
    });
};

/**
 * ToggleLeftCol
 * Muestra o esconde la barra de la izquierda
 * @constructor
 */
$.ToggleLeftCol = function() {
    var leftcol = $("#leftcol");
    leftcol.css("display", "block");
    var rightcol = $("#rightcol");
    var topbar = $("#topbar");
    var midblock = $("#midblock");
    if(leftcol.hasClass("pinned")){
        /*si esta grande, achicarlo*/
        leftcol.removeClass("pinned");
    }
    else {
        /* si esta pequeño agrandarlo*/
        leftcol.addClass("pinned");
    }
    topbar.css("margin-left", leftcol.css("width"));
    topbar.css("width", "calc(100% - "+leftcol.css("width")+")");
    if(rightcol.hasClass("pinned")) {
        var sumCols = parseInt(leftcol.css("width"), 10) + parseInt(rightcol.css("width"), 10);
        midblock.css("width", "calc(100% - " + sumCols + "px)");
    }
    else {
        midblock.css("width", "calc(100% - "+leftcol.css("width")+")");
    }
    midblock.css("margin-left", leftcol.css("width"));
    midblock.css("margin-top", "60px");
};

/**
 * Carga información en la barra lateral 
 *	@arg tipoContenido
 *	@arg idContenido
 */
$.LoadRightCol = function(idTipoRecurso, idRecurso = 0, modo = ""){
    $.ajax({
        data: $.RawData("LoadRightCol", {
            "idTipoRecurso": idTipoRecurso,
            "idRecurso": idRecurso,
            "modo": modo
        }),
        success: function (response) {
            $("#rightcol").html(response);
        },
        complete: function(){}
    });
};

/**
 * ToggleRightCol
 * Muestra u oculta la barra derecha
 * @constructor
 */
$.ToggleRightCol = function(modo){
    var leftcol = $("#leftcol");
    var rightcol = $("#rightcol");
    var midblock = $("#midblock");
    var chat_row = $("#chat_row");

    var action;
    if(modo) {
        action = modo;
    }
    else if(rightcol.hasClass("pinned")) {
        action = "close";
    }
    else if(!rightcol.hasClass("pinned")) {
        action = "open";
    }
    switch (action) {
        case "open":
            rightcol.addClass("pinned");
            $(".icon .info").parent().addClass("active");
            var sumCols = parseInt(leftcol.css("width"), 10) + parseInt(rightcol.css("width"), 10);
            midblock.css("width", "calc(100% - " + sumCols + "px)");
            chat_row.css("right", rightcol.css("width"));
            break;
        case "close":
            rightcol.removeClass("pinned");
            $(".icon .info").parent().removeClass("active");
            midblock.css("width", "calc(100% - " + leftcol.css("width") + ")");
            chat_row.css("right", "0px");
            break;
    }
};

/**
 * Carga la barra superior
 * @param idTipoRecurso
 * @param idRecurso
 * @param modo
 * @constructor
 */
$.LoadTopBar = function(){
    var topbar = $("#topbar");
    topbar.addClass("pinned");
    $.ajax({
        data: $.RawData("LoadTopBar"),
        success: function (response) {
            $("#topbar").html(response);
        },
        complete: function(){}
    });
};

/**
 * Actualiza el panel de botones
 * @param modo
 * @param idRecurso
 * @constructor
 */
$.UpdatePanel = function(modo, idRecurso = 0) {
    $.ajax({
        data: $.RawData("UpdatePanel", {
            "modo": modo,
            "idRecurso": idRecurso
        }),
        success: function (response) {
            $("#panel").html(response);
            var ancho = $(".topbaright").css("width");
            $(".topbarleft").css("max-width", "calc(100% - "+ancho+")");
        },
        complete: function(){}
    });
};

/**
 *
 * @constructor
 */
$.CleanDashboard = function() {
    $("#leftcol").removeClass("pinned");
    $("#leftcol").css("display", "none");
    $("#rightcol").removeClass("pinned");
    $("#topbar").removeClass("pinned");

    $("#midblock").removeClass("logged");
    $("#midblock").css("margin", "0");
    $("#midblock").css("width", "100%");
    $("#chat_row").removeClass("logged");
};

/**
 * Abre y cierra el modulo de cargando
 * @param modo
 * @constructor
 */
$.ToggleLoading = function(modo) {
    let loading = $('#loading');
    switch(modo) {
        case "open":
            loading.addClass("pinned");
            break;
        case "close":
            loading.removeClass("pinned");
            break;
    }
}

/**
 * Roll down horizontal
 * TODO https://css-tricks.com/snippets/jquery/horz-scroll-with-mouse-wheel/
 */
/*
$("body").mousewheel(function(event, delta) {
    console.log("onmouseover");
    $("#neodocs").scrollLeft -= (delta * 30);
});
*/
