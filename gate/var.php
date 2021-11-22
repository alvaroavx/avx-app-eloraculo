<?php
/**
VAR
Version 1: Base Inicial en progreso
Njong Alvax
 */
/**NJONG 25.09.18: Variables del Entorno**/
{
    $Var['Title'] = 'el Oráculo';
    $Var['Description'] = 'Repositorio de conocimientos';
    $Var['Keyword'] = 'eloraculo,oraculo,aplicacion,web,movil,mobile,app,conocimiento,pymes,startup,pyme,sabiduria';
    $Var['Prefix_Fisico'] = '/eloraculo';
}

{
    $Var['Default']['Load'] = 'dashboard';
    $Var['Default']['IdLoad'] = '1';
}

/**NJONG 25.11.05: ROOT**/
{
    $Var['Root']['Base']            = ((defined('Root'))? constant('Root'): $Manifest['Root'] );
    $Var['Root']['AvatarUsuario']   = 'static/avatar/';
    $Var['Root']['BordeAvatar']     = 'static/superAvatar/';
}

/**NJONG 25.11.05: URL**/
{
    $Var['Url']['AvatarDefault']    = 'user_nn.jpg';
}

/**NJONG 25.11.05: LOCAL**/
{
    $Var['Local']['Css']            = '1.0';
    $Var['Local']['Js']             = '1.0';
    $Var['Local']['Favicon']        = '1.0';
}