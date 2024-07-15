<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
$percorso = $_SERVER['PHP_SELF'];
$nome_pagina = basename($percorso);

include 'header.php';
?>
<div class="content">
    <img src="IMMAGINI/simbolo.png" alt="Simbolo del sito">
    <div class="welcome">
        <h2 class="TitoloBenv">Benvenuto</h2>
        <p>Scopri un nuovo modo per interagire con le persone che ami. Fai conoscere al mondo la tua voce scrivendo tweet e tramite la bacheca puoi tenere traccia di tutto quello che hai scritto</p>
        <button onclick="window.location.href='registrazione.php'" class="buttonHome">Registrati</button>
        <button onclick="window.location.href='login.php'" class="buttonHome">Login</button>
    </div>
</div>
<?php 
include 'footer.php';
?>