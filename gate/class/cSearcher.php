<?php
class Searcher extends Wiss{
    public function Search($Busqueda ){
        $Datos['Busqueda']        = $Busqueda;
        $Datos['IdUsuario']       = Sesion('idusuario');
        return Wiss::Query('spRec_Buscador_Buscador', $Datos);
    }
}