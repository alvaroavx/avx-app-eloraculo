<?php
/**
 * Constructor Chat: maneja el codigo del chat
 * elOraculo 2018 Steins
 * @AlvaxVargas
 **/

function LoadChatRow($data){
    FiltrarSesion();
    echo ''
        .'<div id="chat_tab" class="">'
            .'<div id="chat_head" onclick="$.MinChatTab()">'
                .'<div class="head_left" onclick=""></div>'
                .'<div class="head_center" onclick="">Mensajes</div>'
                .'<div class="head_right" onclick="">'
                    .'<div class="icon xs" onclick="$.ToggleChatRow(\'close\')" title="Cerrar chat"><div class="cancelwhite"></div></div>'
                .'</div>'
            .'</div>'
            .'<div id="chattab"></div>'
        .'</div>'
        .'';
}

function LoadChatBody($data){
    FiltrarSesion();
    $Wiss = new Wiss();
    echo ''
        .'<div id="chat_searcher">'
            .'<input type="search" placeholder="A quién deseas hablarle?">'
        .'</div>'
        .'';
    $Contactos = $Wiss->Contactos();
    foreach($Contactos as $co){
        echo '<div class="item_contactorow item_queue" data-u="'.$co['IdUsuario'].'" onclick="$.LoadChatTab(this);"></div>';
    }
    echo '<script>'
        .'$.ContactoLoader();'
        .'</script>';
}

function LoadChatTab($data){
    FiltrarSesion();
    $IdUsuarioDestino = $data['u'];
    $Wiss = new Wiss();
    $DatosUsuario = $Wiss->DatosUsuario($IdUsuarioDestino);
    echo '<div id="head_chattab" onclick="$.MinChatTab();">'
            .'<div class="item_chat_avatar"></div>'
        .'</div>'
        .'<div id="name_chattab" class="a">'.$DatosUsuario['NombreCorto'].'</div>'
        .'<div id="close_chattab" onclick="$.ChatTabToggle(0);"></div>'
        .'';
    $Mensajes = $Wiss->MensajesChat($IdUsuarioDestino);
    echo '<div id="chatrow_chattab">';
    foreach ($Mensajes as $me){
        echo '<div data-u="'.$me['IdUsuarioOrigen'].'">'.$me['Mensaje'].'</div>';
    }
    echo '</div>'
        .'<div id="inputrow_chattab">'
        .'<input id="input_chattab" type="text" placeholder="Escribe acá...">'
        .'<script>$("#input_chattab").bind("keypress", function(e) {$.AgregarMensajeChat(e, this)});</script>'
        .'</div>'
        .'';
}

function LoadContacto($data){
    FiltrarSesion();
    $IdUsuario = $data['u'];

    $Wiss = new Wiss();
    $DatosUsuario = $Wiss->DatosUsuario($IdUsuario);

    echo '<div class="item_chat_avatar"></div>'
        .$DatosUsuario['NombreCorto'];
}

function AgregarMensajeChat($data){
    FiltrarSesion();
    $Wiss = new Wiss();

    $IdUsuarioDestino = $data['u'];
    $Mensaje = $data['mensaje'];

    $Wiss->AgregarChat($IdUsuarioDestino, $Mensaje);

}