<?php
/**
 * xMenu
 * Constructor del Menu del sitio
 * @AlvaxVargas 2018
 **/

/**
 * LoadLeftCol
 * Carga de la barra de contenido izquierda
 * @param $data
 */
function LoadLeftCol($data){
    echo ''
        .'<div id="sidebar">'
        .'<div class="menuoption" onclick="$.OpenNeodoc(0,\'new\')">'
            .'<div class="icon" title="Nuevo"><div class="new"></div></div>'
            .'<div class="label">Nuevo</div>'
        .'</div>'
        .'<hr>'
        .'<div class="menuoption" onclick="$.LoadDashboard()">'
            .'<div class="icon" title="Mi Repositorio"><div class="home"></div></div>'
            .'<div class="label">Mi Repositorio</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadCategorias()">'
            .'<div class="icon" title="Categorías"><div class="box"></div></div>'
            .'<div class="label">Categorías</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadFavoritos()">'
            .'<div class="icon" title="Favoritos"><div class="star"></div></div>'
            .'<div class="label">Favoritos</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadEtiquetas(\'\',\'etiquetas\')">'
            .'<div class="icon" title="Etiquetas"><div class="tags"></div></div>'
            .'<div class="label">Etiquetas</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadCompartidos()">'
            .'<div class="icon" title="Compartidos conmigo"><div class="usershared"></div></div>'
            .'<div class="label">Compartidos conmigo</div>'
        .'</div>'
        .'<hr>'
        .'<div class="menuoption" onclick="$.LoadListas()">'
            .'<div class="icon" title="Listas"><div class="bookmark"></div></div>'
            .'<div class="label">Listas</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadSuscripciones()">'
            .'<div class="icon" title="Suscripciones"><div class="book"></div></div>'
            .'<div class="label">Suscripciones</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadExplorar()">'
            .'<div class="icon" title="Explorar"><div class="globe"></div></div>'
            .'<div class="label">Explorar</div>'
        .'</div>'

        .'<hr>'
        .'<div class="menuoption" onclick="$.LoadConfiguracion()">'
            .'<div class="icon" title="Configuración"><div class="config"></div></div>'
            .'<div class="label">Configuración</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.LoadAyuda()">'
            .'<div class="icon" title="Ayuda"><div class="question"></div></div>'
            .'<div class="label">Ayuda</div>'
        .'</div>'
        .'<hr>'
        .'<div class="menuoption" onclick="$.LoadDeleted()">'
            .'<div class="icon" title="Papelera"><div class="trash"></div></div>'
            .'<div class="label">Papelera</div>'
        .'</div>'
        .'<div class="menuoption" onclick="$.DeleteSesion()">'
            .'<div class="icon" title="Cerrar sesión"><div class="logout"></div></div>'
            .'<div class="label">Cerrar sesión</div>'
        .'</div>'
        .'</div>'
        .'';

    echo '<div id="bottomrow">'
        //.'<div id="contactrow">© All Rights Reserved | el Oráculo 2018</div>'

        .'<div class="menuoption" onclick="">'
        .'<div class="icon" title="Todos los derechos reservados | el Oráculo 2018"><div class="copyright"></div></div>'
        .'<div class="label">Todos los derechos reservados</div>'
        .'</div>'
        .'</div>';
}