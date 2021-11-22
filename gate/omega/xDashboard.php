<?php
/**
 * xDashboard
 * Constructor del contenido general del sitio
 * @AlvaxVargas 2018
**/

/**
 * LoadDashboard
 * Carga del panel inicial del sitio
 * @param $data
 */
function LoadDashboard($data){
    FiltrarSesion();
    echo '<div id="dashboard">';

    /* Modificados recientemente */
    $Neodoc = new Neodoc();
    $Recientes = $Neodoc->getRecientes(20);
    echo '<div id="recents">'
        . '<div class="h1">Modificados recientemente</div>'
        . '<div id="neodocs">';
    foreach ($Recientes as $R) {
        echo '<div id="neodoc_'.$R['IdRecurso'].'" class="neodoc clickable" onclick="$.OpenNeodoc('.$R['IdRecurso'].',\'open\')">'
            .'<div class="titulo">'.$R['Titulo'].'</div>'
            .'<div class="fecha">'.FormatearFecha($R['Fecha'], 19).'</div>'
            .'</div>';
    }
    echo '</div>'
        . '</div>'
        . '';

    /* Nube de etiquetas */
    LoadEtiquetas($data);

    /* Favoritos */
    $data['Top'] = 5;
    LoadFavoritos($data);

    /* Categorías (max 10) */
    $data['Top'] = 5;
    LoadCategorias($data);

    /* Listas (max 10) */
    LoadListas($data);

    /* Compartidos */
    LoadCompartidos($data);

    echo '</div>'; /* #dashboard */

    echo '<script>'
        .'$.UpdatePanel("dashboard");'
        .'</script>';
}

/**
 * Carga de la barra de contenido derecha
 * @param $data
 * @throws Exception
 */
function LoadRightCol($data){
    switch ($data['idTipoRecurso']) {
        case 'neodoc':
            $IdRecurso = $data['idRecurso'];
            $Modo = $data['modo'];
            echo ''
                .'<div id="neoinfo">'
                    .'<div id="social"></div>'
                    .'<div id="detail"></div>'
                    .'<div id="permissions"></div>'
                    .'<div id="activities"></div>'
                    .'<div id="related"></div>'
                .'</div>';
            echo '<script>'
                .'$.LoadInfo('.$IdRecurso.');'
                .'$.LoadDetail('.$IdRecurso.', "'.$Modo.'");'
                .'$.LoadPermissions('.$IdRecurso.');'
                .'$.LoadActivities('.$IdRecurso.');'
                .'$.LoadRelated('.$IdRecurso.');'
                .'</script>';
            break;
        case 'categoria':
            echo ''
                .'<div id="neoinfocat">'
                    .'<div id="detail"></div>'
                .'</div>';
            if($data['idRecurso'] == 0) {
                echo '<script>'
                    .'$.LoadDetailCategoria(0,"catnew");'
                    .'</script>';
            }
            else {
                echo '<script>'
                    .'$.LoadDetailCategoria('.$data['idRecurso'].',"catopen");'
                    .'</script>';
            }


            break;
        case 'categorias':
        case 'dashboard':
        case 'compartidos':
        case 'favoritos':
        case 'listas':
        case 'suscripciones':
        case 'explorar':
        case 'etiquetas':
        default:
            /*echo 'no configurado para '.$data['idTipoRecurso']. ' con id '.$data['idRecurso'];*/
        echo '<script>'
            .'$.ToggleRightCol("close");'
            .'</script>';
            break;
    }
}

/**
 * LoadTopBar: Actualiza informacion en la barra superior
 * @param $data
 */
function LoadTopBar($data){
    echo ''
        .'<div class="topbarcontainer">'
        .'<div id="anchors" class="topbarleft"></div>'
        .'<div id="panel" class="topbaright"></div>'
        .'</div>'
        .'';
}

function LoadAlertBar($data){
    echo ''
        .'<div id="alertview">'
            .'<div class="close">'
                .'<div class="icon" onclick="$.LoadAlertBar(\'close\')" title="Cerrar"><div class="cancel"></div></div>'
            .'</div>'
            .'<div class="message">'.$data['message'].'</div>'
            .'<div class="link" onclick="">Deshacer</div>'
        .'</div>';
}

/**
 * Recarga el contenido del panel de botones de la derecha del topbar
 * @param $data
 */
function UpdatePanel($data) {
    switch ($data['modo']) {
        case 'open':
            /* TODO: falta agregar permisos si puede editar */
            echo ''
                .'<div class="icon" onclick="$.StarNeodoc('.$data['idRecurso'].')" title="Agregar a favoritos"><div class="star"></div></div>'
                .'<div class="icon" onclick="$.CloneNeodoc('.$data['idRecurso'].')" title="Crear una copia"><div class="clone"></div></div>'
                .'<div class="icon" onclick="$.OpenNeodoc('.$data['idRecurso'].',\'edit\')" title="Editar"><div class="edit"></div></div>'
                .'<div class="icon" onclick="$.DeleteNeodoc(\'neodoc\','.$data['idRecurso'].')" title="Eliminar"><div class="delete"></div></div>'
                .'<div class="icon" onclick="$.ToggleRightCol()" title="Ver detalles"><div class="info"></div></div>'
                .'';
            break;
        case 'new':
            echo ''
                .'<div class="icon" onclick="$.CancelNeodoc(\'new\')" title="Cancelar"><div class="cancel"></div></div>'
                .'<div class="icon" onclick="$.SaveNeodoc()" title="Guardar"><div class="save"></div></div>'
                .'<div class="icon" onclick="$.ToggleRightCol()" title="Ver detalles"><div class="info"></div></div>'
                .'';
            break;
        case 'edit':
            echo ''
                .'<div class="icon" onclick="$.StarNeodoc('.$data['idRecurso'].')" title="Agregar a favoritos"><div class="star"></div></div>'
                .'<div class="icon" onclick="$.CancelNeodoc(\'edit\','.$data['idRecurso'].')" title="Cancelar"><div class="cancel"></div></div>'
                .'<div class="icon" onclick="$.SaveNeodoc()" title="Guardar"><div class="save"></div></div>'
                .'<div class="icon" onclick="$.DeleteNeodoc('.$data['idRecurso'].')" title="Eliminar"><div class="delete"></div></div>'
                .'<div class="icon" onclick="$.ToggleRightCol()" title="Ver detalles"><div class="info"></div></div>'
                .'';
            break;
        case 'deleted':
            echo ''
                .'<div class="icon" onclick="$.CancelNeodoc("deleted",'.$data['idRecurso'].')" title="Cerrar"><div class="cancel"></div></div>'
                .'<div class="icon" onclick="$.CloneNeodoc('.$data['idRecurso'].')" title="Crear una copia"><div class="clone"></div></div>'
                .'<div class="icon" onclick="$.RestoreNeodoc("neodoc",'.$data['idRecurso'].')" title="Restaurar"><div class="restore"></div></div>'
                .'<div class="icon" onclick="$.DeleteNeodoc("neodoc",'.$data['idRecurso'].')" title="Eliminar definitivamente"><div class="ban"></div></div>'
                .'<div class="icon" onclick="$.ToggleRightCol()" title="Ver detalles"><div class="info"></div></div>'
                .'';
            break;
        case 'categorias':
            echo ''
                .'<div class="icon" onclick="$.NewCategoria()" title="Nueva Categoría"><div class="new"></div></div>'
                .'';
            break;
        case 'catopen':
            echo ''
                .'<div class="icon" onclick="$.NewCategoria()" title="Nueva Categoría"><div class="new"></div></div>'
                .'<div class="icon" onclick="$.LoadDetailCategoria('.$data['idRecurso'].', "catedit")" title="Editar"><div class="edit"></div></div>'
                .'<div class="icon" onclick="$.DeleteCategoria('.$data['idRecurso'].')" title="Eliminar"><div class="delete"></div></div>'
                .'<div class="icon" onclick="$.ToggleRightCol()" title="Ver detalles"><div class="info"></div></div>'
                .'';
            break;
        case 'catnew':
        case 'catedit':
            echo ''
                .'<div class="icon" onclick="$.CancelCategoria('.$data['idRecurso'].')" title="Cancelar"><div class="cancel"></div></div>'
                .'<div class="icon" onclick="$.SaveCategoria('.$data['idRecurso'].')" title="Guardar"><div class="save"></div></div>'
                .'<div class="icon" onclick="$.DeleteCategoria('.$data['idRecurso'].')" title="Eliminar"><div class="delete"></div></div>'
                .'';
            break;
        case 'favoritos':
            echo 'favoritos';
            break;
        case 'etiquetas':
            echo 'etiquetas';
            break;
        case 'compartidos':
            echo 'compartidos';
            break;
        case 'listas':
            echo 'listas';
            break;
        case 'suscripciones':
            echo 'suscripciones';
            break;
        case 'explorar':
            echo 'explorar';
            break;
        case 'configuracion':
            echo 'configuracion';
            break;
        case 'ayuda':
            echo 'ayuda';
            break;
        case 'eliminados':
            echo 'eliminados';
            break;
        case 'dashboard':
        default:
            echo ''
                .'<div class="icon" onclick="" title="Vista de lista"><div class="list"></div></div>'
                .'<div class="icon" onclick="" title="Vista de cuadrícula"><div class="squares"></div></div>';
            break;
    }
}
