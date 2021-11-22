/**
 * CORE JS
 * Archivo administrador central de Javascript
*/

$.LoadCore = function(){
    $.LoadMidBlock(2);
    $.LoadHeader();
    $.LoadFooter();
    $.LoadTopBar();
    $.LoadModal(0);
};

$.LoadMidBlock = function(init){
    var constructor = $("#constructor");
    var midblock = $("#midblock");
    midblock.addClass("logged");
    init = $.IsNull(init,0);

    $.ajax({
        data: $.RawData("LoadMidBlock",
            {
                "load": constructor.attr("data-load"),
                "idload": constructor.attr("data-idload"),
                "init": init
            }),
        beforeSend: function(){
            midblock.addClass("loading");
        },
        success: function (response){
            if(init>1){
                midblock.html(response);
            }
            else{
                midblock.append(response);
            }
        },
        complete: function(){
            midblock.removeClass("loading");
            $.ToggleLoading("close");
        }
    });
};

$.LoadHeader = function(){
    $.ajax({
        data: $.RawData("LoadHeader"),
        success: function (response) {
            $("header").html(response);
        }
    });
};

$.LoadFooter = function(){
    $.ajax({
        data: $.RawData("LoadFooter"),
        success: function (response) {
            $("footer").html(response);
        }
    });
};

$.LoadTopRightTab = function(source){
    switch ($("#toprighttab").attr("data-source")) {
        case "":
            /* se abre por primera vez */
            $("#toprighttab")
                .attr("data-source", source)
                .addClass("pinned")
                .slideToggle("fast");
            break;
        case source:
            /* si está abierto y presiono el mismo entonces lo cierra */
            if($("#toprighttab").hasClass("pinned")) {
                $("#toprighttab")
                    .attr("data-source", "")
                    .removeClass("pinned")
                    .slideToggle("fast");
            }
            else {
                $("#toprighttab")
                    .attr("data-source", source)
                    .addClass("pinned")
                    .slideToggle("fast");
            }
            break;
        default:
            if($("#toprighttab").hasClass("pinned")) {
                $("#toprighttab")
                    .attr("data-source", source)
            }
            else {
                $("#toprighttab")
                    .attr("data-source", source)
                    .addClass("pinned")
                    .slideToggle("fast");
            }
    }

    $.ajax({
        data: $.RawData("LoadTopRightTab", {
            "source" : source
        }),
        success: function (response) {
            $("#toprighttab").html(response);
        }
    });
};

$.LoadAlertBar = function(action, message=""){
    $("#alertbar")
        .addClass("pinned")
        .toggle("slide");
    setTimeout(function(){
            $("#alertbar")
                .removeClass("pinned")
                .toggle("slide");
        },
        6000
    );
    $.ajax({
        data: $.RawData("LoadAlertBar", {
            "message" : message
        }),
        success: function (response) {
            $("#alertbar").html(response);
        }
    });
};