/**
 * NEODOC JS: Manejo de los Neo Documentos
 * elOraculo 2018 Steins
 * @AlvaxVargas
*/

var editor;

$.ListNeodoc = function(neodocs, origin) {
    $.ajax({
        data: $.RawData("ListNeodoc", {
            "neodocs": neodocs,
            "origin": origin
        }),
        success: function (response) {
            $("#listado").html(response);
        },
        complete: function(){}
    });
};

/**
 * $.OpenNeodoc
 * Abre un Neodoc en el modo solicitado, lectura, edición o nuevo
 * @param idTipoRecurso
 * @param idRecurso
 * @param modo: open, new, edit
 * @constructor
 */
$.OpenNeodoc = function (idRecurso, modo = "open", titulo = "") {
    switch (modo){
        case "edit":
            $.FootPrint("edicion", idRecurso);
            break;
        case "new":
            $.FootPrint("nuevo");
            break;
        case "open":
            $.FootPrint("neodoc", idRecurso);
            break;
    }
    $.ajax({
        data: $.RawData("OpenNeodoc", {
            "idRecurso" : idRecurso,
            "modo"      : modo,
            "titulo"    : titulo
        }),
        success: function (response) {
            $("#midblock").html(response);
            switch (modo) {
                case "open":
                    $.AnchorNeodoc(idRecurso);
                    $.UpdateIndice();
                    break;
                case "edit":
                    $.ToggleIndice("close");
                    break;
            }

        },
        complete: function(){
            var constructor = $("#constructor");
            constructor.attr("data-load", "neodoc");
            constructor.attr("data-idload", idRecurso);
            if (!$("#rightcol").hasClass("pinned")) {
                $.ToggleRightCol();
            }
            $.ToggleLoading("close");
        }
    });
};

/** ETIQUETAS **/

/**
 * Ancla un neodoc al topbar
 * @param idRecurso
 * @constructor
 */
$.AnchorNeodoc = function (idRecurso) {
    var anchors = $("#anchors");
    if(anchors.find(".neoanchor[data-idrecurso=\""+idRecurso+"\"]").text() === "") {
        $.ajax({
            data: $.RawData("AnchorNeodoc", {
                "idRecurso": idRecurso
            }),
            success: function (response) {
                anchors.append(response);
            },
            complete: function () {}
        });
    }
};

/**
 * Elimina el neodoc anclado
 * @param idRecurso
 * @constructor
 */
$.DeleteAnchor = function (recurso) {
    $("#anchors").find(".neoanchor[data-idrecurso=\""+recurso+"\"]").remove();
    $("#anchors").find(".neoanchor[data-etiqueta=\""+recurso+"\"]").remove();
};

$.AnchorEtiqueta = function (etiqueta) {
    var anchors = $("#anchors");
    if(anchors.find(".neoanchor[data-etiqueta=\""+etiqueta+"\"]").text() === "") {
        $.ajax({
            data: $.RawData("AnchorEtiqueta", {
                "etiqueta": etiqueta
            }),
            success: function (response) {
                anchors.append(response);
            },
            complete: function () {}
        });
    }
};

/**
 * $.SaveNeodoc
 * Guarda el Neodoc en la base de datos
 * @constructor
 */
$.SaveNeodoc = function () {
    var neodoc = $("#neodoc"),
        titulo = neodoc.find("input.title").val(),
        contenido = editor.getEditorValue(),
        idrecurso = neodoc.attr("data-idrecurso"),
        etiquetas = $("#etiquetas").text();
    if(titulo === "") {
        neodoc.find(".title").addClass("error");
        neodoc.find(".title").focus();
    }
    else {
        $.ajax({
            data: $.RawData("SaveNeodoc", {
                "idRecurso":    idrecurso,
                "idCategoria":  neodoc.attr("data-idcategoria"),
                "titulo":       titulo,
                "bajada":       "",
                "contenido":    contenido,
            }),
            success: function (response) {
                console.log(response);
                neodoc.html(response);
            },
            complete: function(){
                $.LoadAlertBar("open", "Neodoc guardado :)");
            }
        });
    }
};

/**
 * Maneja el error en la edicion o creacion
 * @param event
 * @param elem
 * @constructor
 */
$.HandleError = function(event, elem) {
    switch (event.key) {
        case "Enter":
            $.SaveNeodoc();
            break;
        case "Tab":
            setTimeout(function(){
                $(".jodit_wysiwyg").focus();
            },0);
            console.log("deberia jodit_wysiwyg");
            break;
        default:
            $(elem).removeClass("error");
            break;
    }
};

/**
 * Marca como eliminado o elimina un Neodoc
 * @param idRecurso
 * @constructor
 */
$.DeleteNeodoc = function (source = "", idRecurso) {
    $.ajax({
        data: $.RawData("DeleteNeodoc", {
            "idRecurso" : idRecurso
        }),
        success: function () {
            switch (source) {
                case "eliminados":
                    $.DeleteAnchor(idRecurso);
                    $.LoadDeleted();
                    break;
                case "neodoc":
                default:
                    $.DeleteAnchor(idRecurso);
                    $.LoadDashboard();
                    break;
            }
        },
        complete: function(){
            $.LoadAlertBar("open", "Neodoc eliminado :)");
        }
    });
};

/**
 * Restaura un Neodoc eliminado
 * @param idRecurso
 * @constructor
 */
$.RestoreNeodoc = function(source = "", idRecurso) {
    $.ajax({
        data: $.RawData("RestoreNeodoc", {
            "idRecurso" : idRecurso
        }),
        success: function () {
            switch (source) {
                case "eliminados":
                    $.AnchorNeodoc(idRecurso);
                    $.LoadDeleted();
                    break;
                case "neodoc":
                default:
                    $.AnchorNeodoc(idRecurso);
                    $.OpenNeodoc(idRecurso);
                    break;
            }
        },
        complete: function(){
            $.LoadAlertBar("open", "Neodoc restaurado, verlo :)");
        }
    });
};

/**
 * Deja un Neodoc en tus favoritos
 * @param idRecurso
 * @constructor
 */
$.StarNeodoc = function(idRecurso) {
    $.ajax({
        data: $.RawData("StarNeodoc", {
            "idRecurso" : idRecurso
        }),
        success: function (response) {
            console.log("Agregar mensaje de ok");
        },
        complete: function(){
            $.LoadAlertBar("open", "Neodoc marcado como favorito :)");
        }
    });
};

/**
 * Cancela la creacion de un Neodoc
 * TODO: agregar funcionalidad de borrar el recien creado
 * @constructor
 */
/**
 *
 * @param idRecurso
 * @constructor
 */
$.CancelNeodoc = function (source = "", idRecurso = 0) {
    if($("#rightcol").hasClass("pinned")) {
        $.ToggleRightCol();
    }
    switch (source) {
        case "edit":
            $.OpenNeodoc(idRecurso, "open");
            break;
        case "deleted":
            $.DeleteAnchor(idRecurso);
            $.LoadDashboard();
            break;
        case "new":
        default:
            $.LoadDashboard();
            break;
    }
};

/**
 * Clona un Neodoc
 * @param idRecurso
 * @constructor
 */
$.CloneNeodoc = function(idRecurso) {
    $.ajax({
        data: $.RawData("CloneNeodoc", {
            "idRecurso" : idRecurso
        }),
        success: function (response) {
            console.log(response);
            $("#midblock").html(response);

        },
        complete: function(){
            $.LoadAlertBar("open", "Neodoc clonado con éxito :)");
        }
    });
};

/**
 * COLUMNA DERECHA
 */

/**
 * Carga información social del right col
 * @param idRecurso
 * @constructor
 */
$.LoadInfo = function(idRecurso) {
    $.ajax({
        data: $.RawData("LoadInfo", {
            "idRecurso" : idRecurso
        }),
        success: function (response) {
            $("#social").html(response);
        },
        complete: function(){}
    });
};

/**
 * Carga detalles del Neodoc en el Right Col
 * @param idRecurso
 * @param modo
 * @constructor
 */
$.LoadDetail = function(idRecurso, modo) {
    $.ajax({
        data: $.RawData("LoadDetail", {
            "idRecurso" : idRecurso,
            "modo" : modo
        }),
        success: function (response) {
            $("#detail").html(response);
        },
        complete: function(){}
    });
};

/**
 * Carga permisos del Neodoc en el Right Col
 * @param idRecurso
 * @constructor
 */
$.LoadPermissions = function(idRecurso) {
    $.ajax({
        data: $.RawData("LoadPermissions", {
            "idRecurso" : idRecurso
        }),
        success: function (response) {
            $("#permissions").html(response);
        },
        complete: function(){}
    });
};

/**
 * Carga actividades del Neodoc en el Right Col
 * @param idRecurso
 * @constructor
 */
$.LoadActivities = function(idRecurso) {
    $.ajax({
        data: $.RawData("LoadActivities", {
            "idRecurso" : idRecurso
        }),
        success: function (response) {
            $("#activities").html(response);
        },
        complete: function(){}
    });
};

/**
 * Carga detalles del Neodoc en el Right Col
 * @param idRecurso
 * @constructor
 */
$.LoadRelated = function(idRecurso) {
    $.ajax({
        data: $.RawData("LoadRelated", {
            "idRecurso" : idRecurso
        }),
        success: function (response) {
            $("#related").html(response);
        },
        complete: function(){}
    });
};

/**
 * Al seleccionar una categoría del right col se actualiza en el neodoc
 * @param elem
 * @constructor
 */
$.UpdateCategoria = function (elem) {
    var idCategoria = $(elem).children("option:selected").val();
    console.log("est es "+idCategoria);
    $("#neodoc").attr("data-idcategoria", idCategoria);
};

var etiqueta = "";
/**
 * Agrega o elimina una etiqueta del neodoc
 * @param event
 * @param elem
 * @constructor
 */
$.UpdateEtiqueta = function (event, elem) {
    switch (event.key) {
        case " ":
        case "Enter":
        case "Space":
            var idNeodoc = $("#neodoc").attr("data-idneo");
            if(etiqueta !== " " && etiqueta) {
                console.log("actualizar etiqueta: "+etiqueta);
                $.ajax({
                    data: $.RawData("SaveEtiqueta", {
                        "etiqueta": etiqueta,
                        "idNeodoc": idNeodoc
                    }),
                    success: function () {
                        $("#existentes").append("<div class=\"tag\">"
                            +"<div class=\"nombre clickable\" title=\'"+etiqueta+"\' onclick=\"$.LoadEtiquetas(\'"+etiqueta+"\', \'etiquetas\')\">#"+etiqueta+"</div>"
                            +"<div class=\"close clickable\" onclick=\"$.DeleteEtiqueta(\'"+etiqueta+"\', this)\">"
                            +"<div class=\"icon small\" title=\"Remover\"><div class=\"cancel\"></div></div>"
                            +"</div>"
                            +"</div>");
                        etiqueta = "";
                        $("#nuevos").val("");
                    },
                    complete: function () {}
                });
            }
            break;
        case "Backspace":
            etiqueta = etiqueta.slice(0, -1);
            break;
        default:
            var inp = String.fromCharCode(event.keyCode);
            if (/[a-zA-Z0-9-_ ]/.test(inp)) {
                etiqueta = etiqueta.concat(event.key);
            }
            break;
    }
};

/**
 * Desasocia o elimina una etiqueta
 * @param etiqueta
 * @param elem
 * @constructor
 */
$.DeleteEtiqueta = function (etiqueta, elem) {
    var idNeodoc = $("#neodoc").attr("data-idneo");

    $.ajax({
        data: $.RawData("DeleteEtiqueta", {
            "etiqueta": etiqueta,
            "idNeodoc": idNeodoc
        }),
        success: function () {
            $(elem).parent().remove();
        },
        complete: function () {
            $.LoadAlertBar("open", "Etiqueta eliminada :)");
        }
    });
};


$.UpdateIndice = function () {
    var body = $("#editor").html();
    $.ajax({
        data: $.RawData("UpdateIndice", {
            "body": body,
        }),
        success: function (response) {
            $("#neoindex").html(response);
        },
        complete: function () {
            $.ToggleIndice("open");
        }
    });
};


$.ToggleIndice = function (action = "") {
    var elem = $("#indexbody");
    var body = $("#neodoc .body");
    if(action === "open") {
        action = "open";
    } else if(action === "close") {
        action = "close";
    } else if(elem.hasClass("pinned")) {
        action = "close";
    } else if(!elem.hasClass("pinned")) {
        action = "open";
    }
    switch (action) {
        case "open":
            elem.addClass("pinned");
            body.addClass("index");
            body.css("width", "calc(100% - "+elem.css("width")+")");
            body.css("margin-left", elem.css("width"));
            break;
        case "close":
            elem.removeClass("pinned");
            body.removeClass("index");
            body.css("width", "calc(100% - "+elem.css("width")+")");
            body.css("margin-left", "auto");
            break;
    }
};