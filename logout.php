<?php
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}

// Rimuovo tutte le var dalla sessione corrente
session_unset();

// Distruggo la sessione 
session_destroy();

// Reindirizzo automaticamente l'utente alla home 
header('Location: home.php');
exit();
?>