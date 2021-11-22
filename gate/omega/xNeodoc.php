<?php
/**
 * Constructor Neodoc
 * Maneja lo relacionado con los Neodocs
 */

/**
 * Devuelve un listado con los Neodocs segun el Referal
 * @param $data
 */
function ListNeodoc($data) {
    $Neodocs = (isset($data['neodocs']) ? $data['neodocs'] : array());
    $Origin = $data['origin'];

    /* TODO: intente juntar los listados pero se complico revisar */
    if(sizeof($Neodocs) === 0) {
        echo '<div id="item" class="item">'
            . '<div class="titulo">No hay Neodocs :c</div>'
            . '</div>';
    }
    else {
        foreach ($Neodocs as $N) {
            switch ($Origin) {
                case 'eliminados':
                    switch ($N['Tipo']) {
                        case 'NEODOC':
                            echo '<div id="item_'.$N['IdRecurso'].'" class="item clickable">'
                                . '<div class="titulo" onclick="$.OpenNeodoc('.$N['IdRecurso'].',\'open\')">'.$N['Titulo'].'</div>'
                                . '<div></div>'
                                . '<div class="botones">';
                            echo 'Neodoc';
                            echo '<div class="icon small" onclick="$.RestoreNeodoc("eliminados",'.$N['IdRecurso'].')" title="Restaurar"><div class="restore"></div></div>'
                                .'<div class="icon small" onclick="$.DeleteNeodoc("eliminados",'.$N['IdRecurso'].')" title="Eliminar definitivamente"><div class="ban"></div></div>';
                            break;
                        case 'CATEGORIA':
                            echo '<div id="item_'.$N['IdRecurso'].'" class="item clickable">'
                                . '<div class="titulo" onclick="$.LoadCategorias('.$N['IdNeodoc'].')">'.$N['Titulo'].'</div>'
                                . '<div></div>'
                                . '<div class="botones">';
                            echo 'Categoría';
                            echo '<div class="icon small" onclick="$.RestoreCategoria('.$N['IdNeodoc'].')" title="Restaurar"><div class="restore"></div></div>'
                                .'<div class="icon small" onclick="$.DeleteCategoria('.$N['IdNeodoc'].')" title="Eliminar definitivamente"><div class="ban"></div></div>';
                            break;
                    }
                    break;
                default:
                    echo '<div id="item_'.$N['IdRecurso'].'" class="item clickable">'
                        . '<div class="titulo" onclick="$.OpenNeodoc('.$N['IdRecurso'].',\'open\')">'.$N['Titulo'].'</div>'
                        . '<div></div>'
                        . '<div class="botones">';
                    echo '<div class="icon small" onclick="$.AnchorNeodoc(\''.$N['IdRecurso'].'\')" title="Anclar"><div class="pin"></div></div>';
                    break;
            }
            echo '</div>'
                . '</div>';
        }
    }
}

/**
 * OpenNeodoc: abre un NeoDoc
 * @param $data
 */
function OpenNeodoc($data){
    $Neodoc = new Neodoc();
    $IdRecurso = $data['idRecurso'];
    $Modo = $data['modo'];
    $Neodoc = $Neodoc->Get($IdRecurso)[0];
    /* TODO arreglar cuando es nuevo y cuando no existe */
    if($IdRecurso == 0) {
        $Modo = 'new';
    }
    else if($Neodoc['IdRecurso'] == -1 && $IdRecurso != 0) {
        $Modo = 'error';
    }
    else if($Neodoc['Estado'] === 'DELETED') {
        $Modo = 'deleted';
    }

    switch ($Modo) {
        case 'open':
        case 'deleted':
            echo ''
                .'<div id="neodocrow">'
                .'<div id="neoindex"></div>'
                .'<div id="neodoc" data-idrecurso="'.$IdRecurso.'" data-idcategoria="'.$Neodoc['IdCategoria'].'" data-idneo="'.$Neodoc['IdNeodoc'].'">'
                .'<div class="title">' . $Neodoc['Titulo'] . '</div>'
                .'<input type="hidden" class="title" placeholder="Ingrese el título"/>'
                .'<div class="body"><div id="editor">'.$Neodoc['Contenido'].'</div></div>'
                .'</div>'
                .'</div>'
                .'';
            echo '<script>'
                . '$.UpdatePanel("'.$Modo.'",'.$IdRecurso.');'
                . '$.LoadRightCol("neodoc",'.$IdRecurso.',"open");'
                . '</script>';
            break;
        case 'new':
            echo ''
                .'<div id="neodocrow">'
                .'<div id="neoindex"></div>'
                .'<div id="neodoc" class="edit" data-idrecurso="0" data-idcategoria="1">'
                .'<input id="neotitle" class="title" placeholder="Ingrese el título" onkeydown="$.HandleError(event, this)" value="'.$data['titulo'].'"/>'
                .'<div id="neobody" class="body" data-text="Ingrese el contenido"><div id="editor"></div></div>'
                .'</div>'
                .'</div>'
                .'';
            echo '<script>'
                .'$.UpdatePanel("'.$Modo.'",0);'
                .'$.LoadRightCol("neodoc", 0, "'.$Modo.'");'
                .'editor = new Jodit("#editor");'
                .'$("#neotitle").focus();'
                .'</script>';
            break;
        case 'edit':
            echo ''
                .'<div id="neodocrow">'
                .'<div id="neoindex"></div>'
                .'<div id="neodoc" class="edit" data-idrecurso="'.$IdRecurso.'" data-idcategoria="'.$Neodoc['IdCategoria'].'" data-idneo="'.$Neodoc['IdNeodoc'].'">'
                .'<input id="neotitle" class="title" value="'.$Neodoc['Titulo'].'" onkeydown="$.HandleError(event, this)"/>'
                .'<div id="neobody" class="body"><div id="editor">'.$Neodoc['Contenido'].'</div></div>'
                .'</div>'
                .'</div>'
                .'';
            echo '<script>'
                .'$.UpdatePanel("'.$Modo.'",'.$IdRecurso.');'
                . '$.LoadRightCol("neodoc",' . $IdRecurso . ', "'.$Modo.'");'
                /*.'$.LoadDetail('.$IdRecurso.', "edit");'*/
                .'editor = new Jodit("#editor");'
                .'$(".jodit_wysiwyg").focus();'
                .'</script>';
            break;
        case 'error':
        default:
            echo '<script>'
                . '$.LoadDashboard();'
                . '</script>';
            break;
    }
}

/**
 * Agrega un neodoc al panel de neodocs
 * @param $data
 */
function AnchorNeodoc($data) {
    $IdRecurso = $data['idRecurso'];
    $Neodoc = new Neodoc();
    $Neodoc = $Neodoc->Get($IdRecurso)[0];

    echo ''
        .'<div id="anchor_'.$IdRecurso.'" data-idrecurso="'.$IdRecurso.'" class="neoanchor" title="'.$Neodoc['Titulo'].'">'
        .'<div class="title clickable" onclick="$.OpenNeodoc('.$IdRecurso.')">'
        //.() ? '' : ''
        .$Neodoc['Titulo']
        .'</div>'
        .'<div class="close clickable" onclick="$.DeleteAnchor('.$IdRecurso.')">'
            .'<div class="icon small" title="Cerrar"><div class="cancel"></div></div>'
        .'</div>'
        .'';
}

function AnchorEtiqueta($data) {
    $Etiqueta = $data['etiqueta'];

    echo ''
        .'<div id="anchor_'.$Etiqueta.'" data-etiqueta="'.$Etiqueta.'" class="neoanchor" title="#'.$Etiqueta.'">'
        .'<div class="title clickable" onclick="$.LoadEtiquetas(\''.$Etiqueta.'\',\'etiquetas\')">'
        .'#'.$Etiqueta
        .'</div>'
        .'<div class="close clickable" onclick="$.DeleteAnchor(\''.$Etiqueta.'\')">'
        .'<div class="icon small" title="Cerrar"><div class="cancel"></div></div>'
        .'</div>'
        .'';
}

/**
 * SaveNeodoc: crea o modifica un NeoDoc
 * @param $data
 */
function SaveNeodoc($data){
    $Neodoc = new Neodoc();
    $IdRecurso      = $data['idRecurso'];
    $IdCategoria    = $data['idCategoria'];
    $Titulo         = $data['titulo'];
    $Bajada         = $data['bajada'];
    $Contenido      = str_replace('\n', '<br/>', utf8_encode($data['contenido']));
    $NuevoIdRecurso = $Neodoc->Save($IdRecurso, $IdCategoria, $Titulo, $Bajada, $Contenido)[0]['IdRecurso'];
    if($NuevoIdRecurso > 0) {
        $IdRecurso = $NuevoIdRecurso;
    }
    echo '<script>'
        .'$.OpenNeodoc('.$IdRecurso.',"open");'
        . '</script>';
}

/**
 * DeleteNeodoc: elimina un NeoDoc
 * @param $data
 */
function DeleteNeodoc($data){
    $Neodoc = new Neodoc();
    $idRecurso = $data['idRecurso'];
    $Neodoc->Delete($idRecurso)[0];
}

/**
 * Restaura de la papelera un neodoc eliminado
 * @param $data
 */
function RestoreNeodoc($data){
    $Neodoc = new Neodoc();
    $idRecurso = $data['idRecurso'];
    $Neodoc->Restore($idRecurso)[0];
}

/**
 * Agrega o elimina un Neodoc de los favoritos
 * @param $data
 */
function StarNeodoc($data){
    $Neodoc = new Neodoc();
    $idRecurso = $data['idRecurso'];
    echo $Neodoc->Star($idRecurso);
}

/**
 * Crea una copia exacta del neodoc
 * @param $data
 */
function CloneNeodoc($data) {
    $Neodoc = new Neodoc();
    $IdRecurso = $Neodoc->Clone($data['idRecurso'])[0];
    print_r($IdRecurso);
    echo '<script>'
        .'$.OpenNeodoc('.$IdRecurso['IdRecurso'].');'
        .'</script>';
    //echo '<script>$.OpenNeodoc('.$nuevoRecurso.')</script>';
}

/**
 * COLUMNA DERECHA
*/

/**
 * Carga informacion social del Neodoc en el Right Col
 * @param $data
 */
function LoadInfo($data) {
    $IdRecurso = $data['idRecurso'];
    $Recurso = new Recurso();

    /* Visitas */
    $Visitas = $Recurso->getActividades(4, $IdRecurso);
    $Visitas = ($Visitas == null) ? 0 : $Visitas[0]['Actividad'];
    echo '<div class="icon labeled" title="Visitas"><div class="eye"></div>'.$Visitas.'</div>';

    /* Seguidores */
    $Seguidores = $Recurso->getActividades(5, $IdRecurso);
    $Seguidores = ($Seguidores == null) ? 0 : $Seguidores[0]['Actividad'];
    echo '<div class="icon labeled" title="Seguidores"><div class="users"></div>'.$Seguidores.'</div>';

    /* Favoritos */
    echo '<div class="icon labeled" title="Favoritos"><div class="heart"></div>'.$Seguidores.'</div>';
}

/**
 * Carga detalles del Neodoc en el Right Col
 * @param $data
 */
function LoadDetail($data) {
    $IdRecurso = $data['idRecurso'];
    $Modo = $data['modo'];
    $Recurso = new Recurso();

    switch ($Modo) {
        case "open":
            /* Autor */
            $Permisos = $Recurso->getPermisos(0, $IdRecurso);
            $Autor = '';
            if($Permisos != null) {
                foreach ($Permisos as $Permiso) {
                    if($Permiso['Perfil'] == 'Autor') {
                        $Wiss = new Wiss();
                        $Autor = $Wiss->DatosUsuario($Permiso['IdUsuario']);
                    }
                }
            }
            /* Categoria */
            $Neodoc = new Recurso();
            $Categoria = $Neodoc->getCategorias($IdRecurso)[0];

            echo ''
                .'<div class="metadata">'
                .'<div class="field">Autor</div>'
                .'<div class="value clickable a" onclick="$.LoadUsuario('.$Autor['IdUsuario'].')">'.$Autor['NombreLargo'].'</div>'
                .'</div>'
                .'<div class="metadata">'
                    .'<div class="field">Categoria</div>'
                .'<div class="value clickable a" onclick="$.LoadCategorias('.$Categoria['IdCategoria'].')">'.$Categoria['Nombre'].'</div>'
                .'</div>'
                .'<div class="metadata">'
                .'<div class="field">Etiquetas</div>'
                .'<div class="value">';

            /* Etiquetas */
            $Recurso = new Recurso();
            $Etiquetas = $Recurso->getEtiquetas(1, $IdRecurso);
            if($Etiquetas == null) {
                echo '<small>Sin Etiquetas</small>';
            }
            else {
                echo '<div id="tags">';
                foreach ($Etiquetas as $Etiqueta) {
                    echo '<div class="tag clickable" onclick="$.LoadEtiquetas(\''.$Etiqueta['Etiqueta'].'\',\'etiquetas\')">#'.$Etiqueta['Etiqueta'].'</div>';
                }
                echo '</div>';
            }
            echo '</div>'
                .'</div>';
            break;
        case "new":
        case "edit":
            /* Categoria */
            $Neodoc = new Recurso();
            $Categoria = $Neodoc->getCategorias($IdRecurso)[0];
            $Categorias = $Neodoc->getCategorias(0);

            echo ''
                .'<div class="metadata">'
                    .'<div class="field">Categoria</div>'
                    .'<div class="value">'
                        .'<select id="value_cat" onchange="$.UpdateCategoria(this)">';
            foreach ($Categorias as $C) {
                if ($Categoria['IdCategoria'] === $C['IdCategoria']) {
                    echo '<option value="' . $C['IdCategoria'] . '" selected>' . $C['Nombre'] . '</option>';
                }
                else {
                    echo '<option value="' . $C['IdCategoria'] . '">' . $C['Nombre'] . '</option>';
                }
            }
            echo '</select>'
                .'</div>'
                .'</div>'
                .'<div class="metadata">'
                .'<div class="field">Etiquetas</div>'
                .'<div class="value">';

            echo '<div id="etiquetas" class="etiquetas">'
                .'<div id="existentes">';
            /* Etiquetas */
            $Recurso = new Recurso();
            $Etiquetas = $Recurso->getEtiquetas(1, $IdRecurso);
            if($Etiquetas != null) {
                foreach ($Etiquetas as $Etiqueta) {
                    echo '<div class="tag">'
                            .'<div class="nombre clickable" title="'.$Etiqueta['Etiqueta'].'" onclick="$.LoadEtiquetas("'.$Etiqueta['Etiqueta'].'","etiquetas")">#'.$Etiqueta['Etiqueta'].'</div>'
                            .'<div class="close clickable" onclick="$.DeleteEtiqueta(\''.$Etiqueta['Etiqueta'].'\', this) ">'
                                .'<div class="icon small" title="Remover"><div class="cancel"></div></div>'
                            .'</div>'
                        .'</div>';
                }
            }
            echo '</div>' /* #existentes */
                .'<input id="nuevos" placeholder="Ingrese etiqueta" onkeyup="$.UpdateEtiqueta(event, this)" />'
                .'</div>' /* #etiquetas */
                .'</div>'
                .'</div>';
            break;
        default:
            break;
    }


    /* Reacciones */
    /*
    echo '<div class="metadata">'
        .'<div class="field">Reacciones</div>'
        .'<div class="value">';
    $Reacciones = $Recurso->getActividades(2, $IdRecurso);
    if($Reacciones == null) {
        echo '<small>Sin Reacciones aún</small>';
    }
    else {
        foreach ($Reacciones as $Reaccion) {}
    }*/
}

/**
 * Carga permisos del Neodoc en el Right Col
 * @param $data
 */
function LoadPermissions($data) {
    $IdRecurso = $data['idRecurso'];
    $Recurso = new Recurso();

    /* Permisos */
    echo '<div class="h3">Permisos</div>';
    $Permisos = $Recurso->getPermisos(0, $IdRecurso);
    if($Permisos == null) {
        echo 'Sin Permisos configurados aún';
    }
    else {
        foreach ($Permisos as $Permiso) {
            echo '<pre>'.print_r($Permiso).'</pre>';
            echo ''
                . 'IdUsuario: ' . $Permiso['IdUsuario'] . '<br/>'
                . 'Perfil: ' . $Permiso['Perfil'] . ' (' . $Permiso['IdPerfil'] . ')<br/>';
        }
    }
}

/**
 * Carga actividades del Neodoc en el Right Col
 * @param $data
 * @throws Exception
 */
function LoadActivities($data) {
    $IdRecurso = $data['idRecurso'];
    $Recurso = new Recurso();

    /* Acciones */
    $Acciones = $Recurso->getActividades(1, $IdRecurso);
    echo '<div class="h3">Actividad</div>';
    if($Acciones == null) {
        echo 'Sin Acciones aún';
    }
    else {
        echo '<ul>';
        foreach ($Acciones as $Accion) {
            $Wiss = new Wiss();
            $Usuario = $Wiss->DatosUsuario($Accion['IdUsuario']);
            $Actividad = $Usuario['NombreCorto'];
            switch ($Accion['Actividad']) {
                case 'CREATE':
                    $Actividad .= ' creó ';
                    break;
                case 'UPDATE':
                    $Actividad .= ' actualizó ';
                    break;
                case 'DELETE':
                    $Actividad .= ' eliminó ';
                    break;
                case 'RESTORE':
                    $Actividad .= ' restauró ';
                    break;
                default:
                    $Actividad = 'Acción '.$Accion['Actividad'].' no configurada';
                    break;
            }
            $Actividad .= strtolower(FormatearFecha($Accion['Fecha']->format('Y-m-d H:i:s'), 19));
            echo '<li>'.$Actividad.'</li>';
        }
        echo '</ul>';
    }
}

/**
 * Carga detalles del Neodoc en el Right Col
 * @param $data
 */
function LoadRelated($data) {
    echo '<div class="h3">Relacionados</div>';
}

/**
 * Actualiza el contenido del índice
 * @param $data
 */
function UpdateIndice($data) {

    echo ''
        .'<div id="indexbtn">'
            .'<div class="icon" onclick="$.ToggleIndice()" title="Índice"><div class="index"></div></div>'
        .'</div>'
        .'';

    $Body = $data['body'];
    $doc = new DOMDocument();
    $doc->loadHTML($Body);
    $XPath = new DOMXpath($doc);
    $Titles = $XPath->query('//h1 | //h2');
    $length = $Titles->length;

    echo ''
        .'<div id="indexbody">'
            /*.'<div id="indextitle">'
                .'<div class="h4">Índice</div>'
            .'</div>'*/
            .'<div id="indexcontent">'
                .'<ul>';

    for ($i = 0; $i < $length; $i++) {
        $element = $Titles->item($i);
        echo '<li class="clickable a t'.$element->tagName.'">'.strip_tags($element->textContent).'</li>';
    }
    echo '</ul>'
            .'</div>'
        .'</div>'
        .'';
}