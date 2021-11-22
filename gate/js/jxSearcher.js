/**
*	CORE JS
*		Archivo administrador central de Javascript
*/

/**
 *
 * @constructor
 */
$.LoadSearcher = function(){
    $.ajax({
        data: $.RawData("LoadSearcher"),
        success: function (response) {
            $("#searchrow").html(response);
        }
    });
};
/**
 *
 * @constructor
 */
$.Search = function(){
    $.ajax({
        data: $.RawData("Search"),
        success: function (response) {
            $("#suggesttab").html(response);
        }
    });
};
/**
 *
 * @constructor
 */
$.LoadSuggestTab = function(){
    $.ajax({
        data: $.RawData("LoadSuggestTab", {
            "busqueda" : $("#input_searchrow").val()
        }),
        success: function (response) {
            $("#suggesttab").html(response);
        },
        complete: function(){
            $("#suggesttab").css("display", "block");
        }
    });
};
/**
 *
 * @param bool
 * @constructor
 */
$.SearchRowToggle = function(bool){
    var tab = $("#suggesttab");
    tab.css({
        width:$("#searchrow").css("width")
        /*left:$("#searchrow").offset()["left"]*/
    });
    if(bool === 1){
        $.LoadSuggestTab();
    }
    else{
        tab.html("").css("display", "none");
    }
};


/**
 * Navega por las sugerencias de resultados
 * @param event
 * @param elem
 * @constructor
 */
var outinput = false;
$.NavigateSuggests = function(event, elem){
    var suggests = $("#suggesttab .item_suggesttab");
    var current = $("#suggesttab .item_suggesttab.item_focus");
    suggests.removeClass("item_focus");
    switch (event.key) {
        case "ArrowDown":
            if(current.next(".item_suggesttab").length === 0){
                suggests.first().addClass("item_focus");
            }
            else {
                current.next(".item_suggesttab").addClass("item_focus");
            }
            outinput = true;
            break;
        case "ArrowUp":
            if(current.prev(".item_suggesttab").length === 0) {
                suggests.last().addClass("item_focus");
            }
            else {
                current.prev(".item_suggesttab").addClass("item_focus");
            }
            outinput = true;
            break;
        case "Enter":
            if(outinput) {
                current.click();
            }
            else {
                $.LoadResultados($("#input_searchrow").val());
            }
            outinput = false;
            $.SearchRowToggle(0);
            break;
        default:
            if($(elem).val().length >=1){
                $.SearchRowToggle(1);
            }
            else{
                $.SearchRowToggle(0);
            }
            break;
    }
};

/**
 *
 * @constructor
 */
$.LoadResultados = function (busqueda = "") {
    $.FootPrint("resultados");
    $.ajax({
        data: $.RawData("LoadResultados", {
            "busqueda" : busqueda
        }),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.ToggleLoading("close");
        }
    });
};


$.FocusSearcher = function () {
    $("#input_searchrow").focus();
};