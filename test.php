<?php
include('valk/loader.php');

print_r($Wiss->Test());
die();

//print_r($Wiss->BuscarUsuarios('rodrigo njong alvaro'));
/* Prueba del buscador */
print_r($Wiss->DatosUsuario(1,1));
//print_r($Wiss->Test());
die();

/* Obtener todas mis etiquetas */
$Recurso = new Recurso();
print_r($Recurso->getEtiquetas(3, 0));
die();

/* Prueba de las Etiquetas */
$Recurso = new Recurso();
$Etiqueta = 'prueba';
$IdNeodoc = 90;
print_r($Recurso->saveEtiqueta($Etiqueta, $IdNeodoc));
die();

/* Prueba de guardado de un neodoc */
$Neodoc = new Neodoc();
$IdNeodoc =     93;
$IdUsuario =    Sesion('idusuario');
$IdCategoria =  1;
$Titulo =       'Prueba que ojalá funcione 23';
$Bajada =       'su bajada piola';
$Contenido =    'estsa si que si y acuerdate del tab oeasdfasdfa ahora si que sioe zi';
echo $Neodoc->Save($IdNeodoc, $IdUsuario, $IdCategoria, $Titulo, $Bajada, $Contenido)[0]['IdRecurso'];
die();

/* chat */
$Wiss = new Wiss();
$DatosUsuario = $Wiss->DatosUsuario(1);
print_r($DatosUsuario);
die();

// prueba del Chat Steins
$Wiss = new Wiss();
$Datos['IdRecurso']        = 8;
$Datos['IdTipoRecurso']        = 1;
$Recurso = $Wiss->Query('spRec_Recurso_Recurso', $Datos);
print_r($Recurso);

die();

// Prueba de envio de correos
$Sobre[]                    = '';
$Sobre['Emisor']            = 'admin@alvax.cl';
$Sobre['Destinatario']      = 'alvaro.vargasdm@gmail.com';
$Sobre['Asunto']            = 'Primer DMail';
$Sobre['Mensaje']           = 'Este es el primer mensaje';
print_r($Wiss->EnviarMail($Sobre['Destinatario'], $Sobre['Asunto'], $Sobre['Mensaje']));

/*
echo '<br><br>';

// Prueba Login: devuelve 1 o 0
$Datos[]                    = '';
$Datos['Usuario']           = 'admin@alvax.cl';
$Datos['Clave']             = 'e10adc3949ba59abbe56e057f20f883e';
print_r($Wiss->ValidaLogin($Datos['Usuario'], $Datos['Clave']));

echo '<br><br>';

$Wiss = new Wiss();
$ValidaUsuario = $Wiss->ValidaLogin($Datos['Usuario'], $Datos['Clave']);
print_r($ValidaUsuario['IdUsuario']);

echo '<br><br>';

// Prueba Datos: trae datos de usuario
$Datos[]                    = '';
$Datos['IdUsuario']         = '2';
$Datos['IP']                = IP();
print_r($Wiss->Login('Datos',$Datos));
*/