/*
	MENU JS
		Archivo encargado de lo que se carga en el menu
*/

/**
* Carga información en la barra lateral
*	@arg tipoContenido
*	@arg idContenido
*/
$.LoadLeftCol = function(data){
    $.ToggleLeftCol();
    $.ajax({
        data: $.RawData("LoadLeftCol"),
        success: function (response) {
            $("#leftcol").html(response);
        },
        complete: function(){}
    });
};