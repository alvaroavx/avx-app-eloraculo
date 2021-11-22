<?php
/**
 * Recurso
 * Clase que maneja los recursos: listas, categorias y etiquetas
 */
class Recurso extends Wiss
{

    /************
     * ETIQUETAS
     ************/
    /**
     * Obtiene las Etiquetas de un Neodoc
     * @param $IdTipoRecurso
     * @param $IdRecurso
     * @return array
     */
    public function getEtiquetas($IdTipoRecurso, $IdRecurso)
    {
        $Datos['IdTipoRecurso'] = $IdTipoRecurso;
        $Datos['IdRecurso']     = $IdRecurso;
        $Datos['IdUsuario']     = Sesion('idusuario');
        return Wiss::Query('spRec_Etiqueta_Etiqueta', $Datos);
    }
    /**
     * Guarda y/o asocia Etiqueta a NeoDoc
     * @param $Etiqueta
     * @param $IdNeodoc
     * @return array
     */
    public function saveEtiqueta($Etiqueta, $IdNeodoc)
    {
        $Datos['Etiqueta'] = $Etiqueta;
        $Datos['IdNeodoc'] = $IdNeodoc;
        return Wiss::Query('spRec_Etiqueta_Neodoc', $Datos);
    }

    /**
     * Desasocia o elimina una etiqueta
     * @param int $IdNeodoc
     * @param string $Etiqueta
     * @return mixed
     */
    public function deleteEtiqueta($IdNeodoc = 0, $Etiqueta = '') {
        $Datos['IdUsuario'] = Sesion('idusuario');
        $Datos['IdNeodoc'] = $IdNeodoc;
        $Datos['Etiqueta'] = $Etiqueta;
        return Wiss::Query('spDel_Recurso_Etiqueta', $Datos);
    }

    /************
     * CATEGORIAS
     ************/
    /**
     * Categoria
     * Obtiene la categoria de un Neodoc, o bien, todas las categorias del usuario
     * o una categoria en particular con su id
     * @param $IdRecurso
     * @param $IdCategoria
     * @return array
     */
    public function getCategorias($IdRecurso = 0, $IdCategoria = 0)
    {
        $Datos['IdUsuario'] = Sesion('idusuario');
        $Datos['IdRecurso'] = $IdRecurso;
        $Datos['IdCategoria'] = $IdCategoria;
        return Wiss::Query('spRec_Categoria_Categoria', $Datos);
    }

    /**
     * Crea o actualiza una Categoria
     * @param $Nombre
     * @param $Descripcion
     * @param int $IdRecurso
     * @return mixed
     */
    public function saveCategoria($Nombre, $Descripcion = '', $IdCategoria = 0) {
        $Datos['IdUsuario'] = Sesion('idusuario');
        $Datos['Nombre']    = $Nombre;
        $Datos['Descripcion'] = $Descripcion;
        $Datos['IdCategoria'] = $IdCategoria;
        return Wiss::Query('spIns_Recurso_Categoria', $Datos);
    }

    /**
     * Marca como eliminado o elimina una Categoria
     * @param $IdCategoria
     * @return mixed
     */
    public function deleteCategoria($IdCategoria) {
        $Datos['IdUsuario'] = Sesion('idusuario');
        $Datos['IdCategoria']    = $IdCategoria;
        return Wiss::Query('spDel_Recurso_Categoria', $Datos);
    }

    /**
     * getPermisos
     * Obtiene los Permisos de un Recurso y/o Usuario
     * @param $IdUsuario
     * @param $IdRecurso
     * @return array
     */
    public function getPermisos($IdUsuario, $IdRecurso)
    {
        $Datos['IdUsuario'] = $IdUsuario;
        $Datos['IdRecurso'] = (isset($IdRecurso) ? $IdRecurso : 0);
        return Wiss::Query('spRec_Recurso_Permiso', $Datos);
    }

    /**
     * getActividades
     * Obtiene las Actividades de un Recurso
     * 1: Accion
     * 2: Reaccion
     * 3: Permiso
     * 4: Visitas
     * 5: Seguidores
     * @param $IdTipoActividad
     * @param $IdRecurso
     * @return array
     */
    public function getActividades($IdTipoActividad, $IdRecurso)
    {
        $Datos['IdTipoActividad'] = $IdTipoActividad;
        $Datos['IdRecurso']     = $IdRecurso;
        return Wiss::Query('spRec_Actividad_Actividad', $Datos);
    }

}

