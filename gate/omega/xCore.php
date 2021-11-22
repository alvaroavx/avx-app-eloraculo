<?php
/**
 * xCore
 * Constructor de la estructura inicial del sitio
 * @AlvaxVargas Steins 2018
 **/

/**
 * EstructuraBase
 * Carga la estructura base dentro del midblock
 */
function EstructuraBase(){
    FiltrarSesion();
    echo '<script>'
        .'$.HeartBeat();'
        .'</script>';
}

/**
 * LoadMidBlock
 * Encargada de actualizar el contenido central del sitio
 * @param $data
 */
function LoadMidBlock($data){
    $Load = $data['load'];
    $IdLoad = $data['idload'];
    /**
     * Init 0 Solo recarga desktop
     * Init 1 Desktop + Row
     * Init 2 Midblock
     */
    $Init = $data['init'];

    /** Opción 1: Sin sesion **/
    if(! ValidaSesion()) {
        echo '<script>$.CleanDashboard();</script>';
        switch ($Load) {
            case 'recover':
	            echo '<div id="fondo_portada">'
		            . '<div id="logo_portada"></div>';
	            LoadRecoverPush($data);
	            echo '</div>';
                break;
            default:
                echo '<div id="fondo_portada">'
                        .'<div class="icon" onclick=""><div class="eloraculoportada"></div></div>'
                        .'<div id="logo_portada">el Oráculo</div>'
                        .'<div id="contenedor_form">';
                LoadLogin($data);
	            echo '</div>'
                    .'</div>';
        }
    }
    /** Opción 2: Logueado **/
    else {
        if($Init >= 2){
            EstructuraBase();
        }
        echo '<script>';
        if ($Init >= 1){
            /** Opción 2.1: Back Office **/
            if (in_array($Load, ['admin'])) {

            }
            /** Opción 2.1: Front Office **/
            else{
                echo''
                    .'$.LoadLeftCol();'
                    .'$.LoadChatRow();'
                    .'';
            }
        }
        /** Opción 3: Enlaces directos **/
        switch ($Load) {
            case 'neodoc':
                echo '$.OpenNeodoc('.$IdLoad.',"open");';
                break;
            case 'edicion':
                echo '$.OpenNeodoc('.$IdLoad.',"edit");';
                break;
            case 'searchinput':
                echo '$.LoadDashboard();';
                break;
            case 'favoritos':
                echo '$.LoadFavoritos();';
                break;
            case 'compartidos':
                echo '$.LoadCompartidos();';
                break;
            case 'categorias':
                echo '$.LoadCategorias();';
                break;
            case 'listas':
                echo '$.LoadListas();';
                break;
            case 'suscripciones':
                echo '$.LoadSuscripciones();';
                break;
            case 'etiquetas':
                /*echo '$.LoadEtiquetas();';*/
                echo '$.LoadEtiquetas("","etiquetas");';
                break;
            case 'explorar':
                echo '$.LoadExplorar();';
                break;
            case 'eliminados':
                echo '$.LoadDeleted();';
                break;
            case 'resultados':
                echo '$.LoadResultados();';
                break;
            case 'configuracion':
            case 'ayuda':
            case 'dashboard':
            default:
                echo '$.LoadDashboard();';
                break;
        }
        echo '</script>';
    }
}

/**
 * LoadHeader
 * Encargada de actualizar la cabecera
 * @param $data
 */
function LoadHeader($data){
    if(ValidaSesion()) {
        echo ''
            .'<div id="header">'
                .'<div class="topleft">'
                    .'<div class="icon" onclick="$.ToggleLeftCol()"><div class="bars"></div></div>'
                    .'<div class="brand clickable" onclick="$.LoadDashboard()"><span class="only-desktop">el Oráculo</span> <div class="icon" onclick=""><div class="eloraculo"></div></div></div>'
                .'</div>'
                .'<div class="topcenter">'
                    .'<div id="searchrow"></div>'
                .'</div>'
                .'<div class="topright">'
                    .'<div class="icon" onclick="$.LoadTopRightTab(\'notifications\')" title="Notificaciones"><div class="bell"></div></div>'
                    .'<div class="icon" onclick="$.LoadTopRightTab(\'messages\')" title="Mensajes"><div class="comments"></div></div>'
                    .'<div class="icon" onclick="$.LoadTopRightTab(\'profile\')" title="Cuenta de usuario"><div class="user"></div></div>'
                .'</div>'
                .'<div id="toprighttab" data-source=""></div>'
            .'</div>'
            .'';

        echo '<script>$.LoadSearcher();</script>';

        echo '<script>'
            .'$("#toprighttab").mouseleave(function(){'
                .'$(this).slideToggle("fast").removeClass("pinned").attr("data-source", "")'
            .'});'
            .'</script>';
    }
    else{
        echo '';
    }
}

/**
 * LoadFooter
 * Encargado de actualizar el pie de pagin
 * @param $data
 */
function LoadFooter($data){
    echo '<div id="chat_row" class="minimize"></div>';
}

/**
 * LoadTopRightTab
 * Encargada de actualizar la columna derecha del encabezado
 * @param $data
 */
function LoadTopRightTab($data){
    if(ValidaSesion()) {
        /* TODO: separar estos tres no tiene sentido que esten en una misma funcion*/
        switch ($data['source']) {
            case 'notifications':
                echo ''
                    .'Soy el LoadTopRightTab de notifications'
                    .'';
                break;
            case 'messages':
                echo ''
                    .'Soy el LoadTopRightTab de messages'
                    .'';
                echo '<script>$.ToggleChatRow("open")</script>';
                break;
            case 'profile':
                $Wiss = new Wiss();
                $DatosUsuario = $Wiss->DatosUsuario(Sesion('idusuario'));
                echo ''
                    .$DatosUsuario['NombreLargo'].'<br/>'
                    .$DatosUsuario['UrlAvatar'].'<br/>'
                    .$DatosUsuario['IdNivelUsuario'].'<br/>'
                    .$DatosUsuario['NivelUsuario']
                    .'';
                break;
        }
    }
    else{
        echo 'No estas logueado, login';
    }
}
function LoadCoreRegistro($data){
	echo '<div id="fondo_portada">'
		.'<div id="logo_portada"></div>';
	LoadRegistro($data);
	echo '</div>';
}
function LoadCoreRecoverPass($data){
	echo '<div id="fondo_portada">'
		.'<div id="logo_portada"></div>';
	LoadRecoverPass($data);
	echo '</div>';
}
function LoadWaitRecover($data){
	echo '<div id="fondo_portada">'
		.'<div id="logo_portada"></div>';
	WaitRecover($data);
	echo '</div>';
}