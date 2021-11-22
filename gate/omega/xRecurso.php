<?php
/**
 * xRecurso
 * Constructor que maneja los recursos: listas, categorias y etiquetas
 */

/*************
 * CATEGORIAS
 *************/

/**
 * Muestra las Categorias
 * @param $data
 */
function LoadCategorias($data){
    $Recurso = new Recurso();
    $Categorias = $Recurso->getCategorias();
    echo '<div id="listadorow">'
        . '<div class="h1">Categorías <div class="icon" title="Categorías" onclick="$.LoadCategorias()"><div class="box"></div></div></div>'
        . '<div id="listado">';
    /* TODO: hacer con un maximo Top */
    foreach ($Categorias as $C) {
        echo '<div id="cat_'.$C['IdCategoria'].'" class="item clickable" onclick="$.LoadCategorias('.$C['IdCategoria'].')">'.$C['Nombre'].'</div>';
    }
    echo '<div class="footnote a" onclick="$.LoadCategorias()">Ver todos</div>'
        .'</div>'
        .'</div>';

    echo '<div id="neocategorias"></div>';
}

function LoadCategoria($data){
    if($data['idCategoria'] !== '') {
        $Neodoc = new Neodoc();
        $data = array(
            'neodocs'   => $Neodoc->getByCategoria($data['idCategoria']),
            'origin'    => 'categorias'
        );
        echo '<div id="listadorow">'
            .'<div id="listado">';
        echo ListNeodoc($data);
        echo '</div>'
            .'</div>';
    }

}

function LoadDetailCategoria($data) {
    $Modo = $data['modo'];
    $Recurso = new Recurso();
    switch ($Modo) {
        case 'catopen':
            $Categoria = $Recurso->getCategorias(0, $data['idCategoria'])[0];
            $Nombre = ($Categoria['Nombre'] ? $Categoria['Nombre'] : '');
            $Descripcion = (isset($Categoria['Descripcion']) ? $Categoria['Descripcion'] : '');
            echo ''
                .'<div class="metadata">'
                .'<div class="field">Nombre</div>'
                .'<div class="value clickable a">'.$Nombre.'</div>'
                .'</div>'
                .'<div class="metadata">'
                .'<div class="field">Descripción</div>'
                .'<div class="value clickable a">'.$Descripcion.'</div>'
                .'</div>'
                .'</div>';
            break;
        case 'catedit':
        case 'catnew':
            if($data['idCategoria'] == "0") {
                $Nombre = '';
                $Descripcion = '';
            }
            else {
                $Categoria = $Recurso->getCategorias(0, $data['idCategoria'])[0];
                $Nombre = ($Categoria['Nombre'] ? $Categoria['Nombre'] : '');
                $Descripcion = ($Categoria['Descripcion'] ? $Categoria['Descripcion'] : '');
            }

            echo ''
                .'<div class="metadata">'
                    .'<div class="field">Nombre</div>'
                    .'<div class="value">'
                        .'<input id="catname" name="catname" placeholder="Ingrese nombre" value="'.$Nombre.'"/>'
                    .'</div>'
                .'</div>'
                .'<div class="metadata">'
                    .'<div class="field">Descripción</div>'
                    .'<div class="value">'
                         .'<textarea id="catdescription" name="catdescription" placeholder="Qué contiene esta categoría?">'.$Descripcion.'</textarea>'
                    .'</div>'
                .'</div>';
            break;
    }
}

function SaveCategoria($data) {
    $Recurso = new Recurso();
    $IdCategoria = $data['idCategoria'];
    $Nombre = str_replace('\n', '<br/>', utf8_encode($data['nombre']));
    $Descripcion = str_replace('\n', '<br/>', utf8_encode($data['descripcion']));
    $NuevoIdCategoria = $Recurso->saveCategoria($Nombre, $Descripcion, $IdCategoria);
    if($NuevoIdCategoria > 0) {
        $IdCategoria = $NuevoIdCategoria;
    }
    /*print_r($NuevoIdCategoria);
    echo '<script>'
        .'$.LoadCategorias("'.$IdCategoria.'");'
        . '</script>';*/
}

/**
 * Marca para eliminar o elimina una Categoria
 * @param $data
 */
function DeleteCategoria($data) {
    $Recurso = new Recurso();
    $Recurso->deleteCategoria($data['idCategoria']);
}

/**
 * LoadFavoritos
 * Muestra los Neodocs favoritos
 * @param $data
 */
function LoadFavoritos($data){
    $Neodoc = new Neodoc();
    $Favoritos = (isset($data['Top']) ? $Neodoc->getFavoritos($data['Top']) : $Neodoc->getFavoritos());
    /*$data['neodocs'] = $Favoritos;*/
    $data = array(
        'neodocs' => $Favoritos,
        'origin' => 'favoritos'
    );
    echo '<div id="listadorow">'
        . '<div class="h1">Favoritos <div class="icon" title="Favoritos" onclick="$.LoadFavoritos()"><div class="star"></div></div></div>'
        . '<div id="listado">';
    echo ListNeodoc($data);
    echo '<div class="footnote a" onclick="$.LoadFavoritos()">Ver todos</div>'
        .'</div>'
        .'</div>';
}

/*************
 * ETIQUETAS
 *************/

/**
 * Muestra las etiquetas personales
 * @param $data
 */
function LoadEtiquetas($data){
    $Recurso = new Recurso();
    $tags = $Recurso->getEtiquetas(3, 0);

    $Origin = (in_array('origin', $data) ? $data['origin'] : '');
    /*$Etiqueta = (in_array('etiqueta', $data) ? $data['etiqueta'] : '');*/

    echo '<div id="listadorow">'
        .'<div class="h1">Etiquetas <div class="icon" title="Etiquetas" onclick=""><div class="tags"></div></div></div>'
        .'<div id="tagscontainer">'
        .'<div id="tags">';
    switch ($Origin) {
        case 'etiquetas':
            foreach ($tags as $tag) {
                echo '<div id="tag_'.$tag['IdEtiqueta'].'" class="tag clickable" onclick="$.LoadEtiqueta(\''.$tag['Etiqueta'].'\')">#'
                    .$tag['Etiqueta'].' ('.$tag['Cantidad'].')'
                    .'</div>';
            }
            break;
        default:
            foreach ($tags as $tag) {
                echo '<div id="tag_'.$tag['IdEtiqueta'].'" class="tag clickable" onclick="$.LoadEtiquetas(\''.$tag['Etiqueta'].'\',\'etiquetas\')">#'
                    .$tag['Etiqueta'].' ('.$tag['Cantidad'].')'
                    .'</div>';
            }
            break;
    }
    echo '</div>'
        .'</div>'
        .'</div>'; /* #tagscontainer */

    echo '<div id="neoetiquetas"></div>';
}

/**
 * Carga los Neodoc de una Etiqueta en particular
 * @param $data
 */
function LoadEtiqueta($data) {
    if($data['etiqueta'] !== '') {
        $Neodoc = new Neodoc();
        $data = array(
            'neodocs'   => $Neodoc->getByEtiqueta($data['etiqueta']),
            'origin'    => 'etiquetas'
        );
        echo '<div id="listadorow">'
            .'<div id="listado">';
        echo ListNeodoc($data);
        echo '</div>'
            .'</div>';
    }
}

/**
 * Guarda o asocia una Etiqueta al Neodoc
 * @param $data
 */
function SaveEtiqueta($data) {
    $Etiqueta = $data['etiqueta'];
    $IdNeodoc = $data['idNeodoc'];
    $Recurso = new Recurso();
    $Recurso->saveEtiqueta($Etiqueta, $IdNeodoc);
}

/**
 * Desasocia o elimina una etiqueta
 * @param $data
 */
function DeleteEtiqueta($data) {
    $IdNeodoc = $data['idNeodoc'];
    $Etiqueta = $data['etiqueta'];
    $Recurso = new Recurso();
    $Recurso->deleteEtiqueta($IdNeodoc, $Etiqueta);
}

/**
 * Muestra los Neodocs compartidos
 * @param $data
 */
function LoadCompartidos($data){
    echo '<div id="listadorow">'
        . '<div class="h1">Compartidos conmigo <div class="icon" title="Compartidos conmigo"><div class="usershared"></div></div></div>'
        . '<div id="listado">';
    for ($i = 0; $i <5; $i++) {
        echo '<div id="cat_' . $i . '" class="item clickable" onclick="$.OpenNeodoc()">'.$i.'</div>';
    }
    echo '<div class="footnote a" onclick="$.LoadCompartidos()">Ver todos</div>'
        .'</div>'
        .'</div>';
}

/**
 * Muestra las Listas
 * @param $data
 */
function LoadListas($data){
    echo '<div id="listadorow">'
        . '<div class="h1">Listas <div class="icon" title="Listas" onclick="$.LoadListas()"><div class="bookmark"></div></div></div>'
        . '<div id="listado">';
    for ($i = 0; $i <5; $i++) {
        echo '<div id="cat_' . $i . '" class="item clickable" onclick="$.OpenList()">'.$i.'</div>';
    }
    echo '<div class="footnote a" onclick="$.LoadListas()">Ver todos</div>'
        .'</div>'
        .'</div>';
}

/**
 * Muestra la Papelera de Reciclaje
 * @param $data
 */
function LoadDeleted($data) {
    $Neodoc = new Neodoc();
    $Eliminados = $Neodoc->getEliminados();
    /*$data['neodocs'] = $Eliminados;
    $data['origin'] = 'eliminados';*/
    $data = array(
        'neodocs' => $Eliminados,
        'origin' => 'eliminados'
    );
    echo '<div id="listadorow">'
        . '<div class="h1">Papelera de Reciclaje <div class="icon" title="Papelera"><div class="trash"></div></div></div>'
        . '<div id="listado">';
    echo ListNeodoc($data);
    echo '</div>'
        .'</div>';
}

/**
 * Muestra las Suscripciones
 * @param $data
 */
function LoadSuscripciones($data){
    echo "Suscripciones";
}

/**
 * Carga la vista de exploracion de Neodocs
 * @param $data
 */
function LoadExplorar($data){
    echo "Explorar";
}


/**
 * Carga la configuracion
 * @param $data
 */
function LoadConfiguracion($data) {
    echo 'Configuración';
}

/**
 * Carga la ayuda
 * @param $data
 */
function LoadAyuda($data) {
    echo 'Ayuda';
}


