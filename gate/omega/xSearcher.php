<?php
/**
 * xSearcher.php
 * Constructor del buscador
 * @copyright elOraculo 2018 Steins
 * @author AlvaxVargas
 * @author Njong
 **/

function LoadSearcher($data){
    FiltrarSesion();

    echo '<div id="searchcontainer" onclick="$.FocusSearcher()">'
            .'<div class="icon" title="Ver todos" onclick="$.LoadResultados()"><div class="search"></div></div>'
            .'<div id="searcher">'
                .'<input type="text" id="input_searchrow" placeholder="En qué puedo ayudarte?" autocomplete="off" onkeyup="$.NavigateSuggests(event, this)" spellcheck="false"/>'
            .'</div>'
        .'</div>'
        .'<div id="suggesttab"></div>';
}
function LoadSuggestTab($data){
    FiltrarSesion();
    $Busqueda = $data['busqueda'];

    $Searcher = new Searcher();

    $Resultados = $Searcher->Search($Busqueda);
    $Contador = 1;
    if(isset($Resultados[0])){
        foreach ($Resultados as $re){
            if($Contador <= 10 ){
                echo  '<div class="item_suggesttab" onclick="$.OpenNeodoc('.$re['IdRecurso'].',\'open\');">'.strip_tags($re['Titulo']).'</div>';
                $Contador++;
            }
            else{
                echo  '<div class="item_suggesttab" onclick="$.LoadResultados("'.$Busqueda.'")">Ver más resultados.</div>';
                break;
            }
        }
    }
    else{
        echo ''
            .'<div class="item_suggesttab">No se han encontrado coincidencias.</div>'
            .'<div class="item_suggesttab" onclick="$.OpenNeodoc(0,"new","'.$Busqueda.'")">Crear <b>"'.$Busqueda.'"</b>?.</div>';
    }

    echo '<script>'
        .'$("#suggesttab").mouseleave(function(){
            $.SearchRowToggle();
        });'
        .'</script>';

}


/**
 * LoadResultados
 * Muestra la vista extendida de resultados de búsqueda
 * @param $data
 */
function LoadResultados($data){
    $Busqueda = $data['busqueda'];
    $Searcher = new Searcher();

    $Resultados = $Searcher->Search($Busqueda);

    $Data = array(
        'neodocs' => $Resultados,
        'origin'  => 'resultados'
    );
    echo '<div id="listadorow">'
        . '<div class="h1">Resultados <div class="icon" title="Resultados"><div class="star"></div></div></div>'
        . '<div id="listado">';
    echo ListNeodoc($Data);
    echo '<div class="footnote a" onclick="$.LoadResultados()">Ver todos</div>'
        .'</div>'
        .'</div>';

}