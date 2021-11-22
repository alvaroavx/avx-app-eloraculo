/**
 * Recurso JS: Manejo de los Recursos
 * elOraculo 2018 Steins
 * @AlvaxVargas
*/

/**
 * Carga sección de Categorias
 * @constructor
 */
$.LoadCategorias = function (idCategoria = 0) {
    $.FootPrint("categorias");
    $.ajax({
        data: $.RawData("LoadCategorias"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            if(idCategoria > 0) {
                $.LoadCategoria(idCategoria);
            }
            else {
                $.UpdatePanel("categorias");
                $.LoadRightCol("categorias");
            }
            $.ToggleLoading("close");
        }
    });
};

/**
 * Abre formulario creacion Categoria
 * @constructor
 */
$.NewCategoria = function () {
    $.LoadRightCol("categoria", 0);
    $.LoadDetailCategoria(0, "catnew");
};

/**
 * Carga los Neodocs de una Categoria
 * @param idCategoria
 * @constructor
 */
$.LoadCategoria = function (idCategoria) {
    $.ajax({
        data: $.RawData("LoadCategoria", {
            "idCategoria": idCategoria
        }),
        success: function (response) {
            $("#neocategorias").html(response);
        },
        complete: function(){
            $.LoadRightCol("categoria", idCategoria);
        }
    });
};

/**
 * Carga el detalle de información de la Categoria
 * @param idCategoria
 * @param modo
 * @constructor
 */
$.LoadDetailCategoria = function (idCategoria, modo) {
    $.ajax({
        data: $.RawData("LoadDetailCategoria", {
            "idCategoria": idCategoria,
            "modo": modo
        }),
        success: function (response) {
            $("#detail").html(response);
        },
        complete: function(){
            $.UpdatePanel(modo, idCategoria);
            $.ToggleRightCol("open");
        }
    });
};

/**
 * Cancela la creación o edición de una Categoria
 * @param idRecurso
 * @constructor
 */
$.CancelCategoria = function (idRecurso) {
    if($("#rightcol").hasClass("pinned")) {
        $.ToggleRightCol();
    }
    if(idRecurso > 0) {
        $.LoadDetailCategoria(idRecurso, "catopen");
    }
    else {
        $.LoadCategorias();
    }
};

/**
 * Guarda la Categoria
 * @param idCategoria
 * @constructor
 */
$.SaveCategoria = function (idCategoria = 0) {
    var nombre = $("#catname");
    var descripcion = $("#catdescription");
    if(nombre.val() === "") {
        nombre.addClass("error");
        nombre.focus();
    }
    else {
        $.ajax({
            data: $.RawData("SaveCategoria", {
                "idCategoria": idCategoria,
                "nombre": nombre.val(),
                "descripcion": descripcion.val()
            }),
            success: function (response) {
                /* TODO mostrar modal con mensaje de guardado */
                $.LoadCategorias(idCategoria);
            },
            complete: function () {}
        });
    }
};

$.DeleteCategoria = function (idCategoria) {
    $.ajax({
        data: $.RawData("DeleteCategoria", {
            "idCategoria": idCategoria
        }),
        success: function (response) {
            /* TODO mostrar modal con mensaje de ELIMINADO */
            $.LoadCategorias();
        },
        complete: function () {}
    });
};

/**
 * Carga los Neodocs Favoritos
 * @param idTipoRecurso
 * @param idRecurso
 * @constructor
 */
$.LoadFavoritos = function () {
    $.FootPrint("favoritos");
    $.ajax({
        data: $.RawData("LoadFavoritos"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("favoritos");
            $.LoadRightCol("favoritos");
            $.ToggleLoading("close");
        }
    });
};

/**
 * Carga sección de Etiquetas
 * @param etiqueta
 * @param origin
 * @constructor
 */
$.LoadEtiquetas = function (etiqueta = "", origin = "") {
    $.FootPrint("etiquetas");
    $.ajax({
        data: $.RawData("LoadEtiquetas", {
            "etiqueta": etiqueta,
            "origin": origin
        }),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            if(etiqueta!== "") {
                $.LoadEtiqueta(etiqueta, origin);
            }
            $.UpdatePanel("etiquetas");
            $.LoadRightCol("etiquetas");
            $.ToggleLoading("close");
        }
    });
};

/**
 * Carga una etiqueta
 * @param etiqueta
 * @param origin
 * @constructor
 */
$.LoadEtiqueta = function (etiqueta = "", origin = "") {
    console.log("LoadEtiqueta " + etiqueta + " vengo de " + origin);
    $.ajax({
        data: $.RawData("LoadEtiqueta", {
            "etiqueta": etiqueta,
            "origin": origin
        }),
        success: function (response) {
            $("#neoetiquetas").html(response);
            $.AnchorEtiqueta(etiqueta);
        },
        complete: function(){
            /*$.LoadRightCol("ayuda");*/
        }
    });
};

/**
 * Carga sección Compartidos conmigo
 * @constructor
 */
$.LoadCompartidos = function () {
    $.FootPrint("compartidos");
    $.ajax({
        data: $.RawData("LoadCompartidos"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("compartidos");
            $.LoadRightCol("compartidos");
            $.ToggleLoading("close");
        }
    });
};

/**
 *
 * @constructor
 */
$.LoadListas = function () {
    $.FootPrint("listas");
    $.ajax({
        data: $.RawData("LoadListas"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("listas");
            $.LoadRightCol("listas");
            $.ToggleLoading("close");
        }
    });
};

/**
 *
 * @constructor
 */
$.LoadSuscripciones = function () {
    $.FootPrint("suscripciones");
    $.ajax({
        data: $.RawData("LoadSuscripciones"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("suscripciones");
            $.LoadRightCol("suscripciones");
            $.ToggleLoading("close");
        }
    });
};

/**
 *
 * @constructor
 */
$.LoadExplorar = function () {
    $.FootPrint("explorar");
    $.ajax({
        data: $.RawData("LoadExplorar"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("explorar");
            $.LoadRightCol("explorar");
        }
    });
};

/**
 *
 * @constructor
 */
$.LoadConfiguracion = function () {
    $.FootPrint("configuracion");
    $.ajax({
        data: $.RawData("LoadConfiguracion"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("configuracion");
            $.LoadRightCol("configuracion");
        }
    });
};

/**
 *
 * @constructor
 */
$.LoadAyuda = function () {
    $.FootPrint("ayuda");
    $.ajax({
        data: $.RawData("LoadAyuda"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("ayuda");
            $.LoadRightCol("ayuda");
        }
    });
};

/**
 * Muestra la papelera
 * @constructor
 */
$.LoadDeleted = function() {
    $.FootPrint("eliminados");
    $.ajax({
        data: $.RawData("LoadDeleted"),
        success: function (response) {
            $("#midblock").html(response);
        },
        complete: function(){
            $.UpdatePanel("eliminados");
            $.LoadRightCol("eliminados");
        }
    });
};

/**
 *
 * @constructor
 */
$.OpenList = function () {
    console.log("soy OpenList programame c:");
};