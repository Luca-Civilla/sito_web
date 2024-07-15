<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf8">
        <link rel="icon" type="image/png" href="IMMAGINI/logo.png">
        <meta name="viewport" content="width=device-width, initial-scale=0.65">
        <link rel="stylesheet" href="style.css">
        <script src='validatoreJAVA.js'></script>"
        <title><?php echo $nome_pagina; ?></title> 
    </head>
    <body>
       
        <div class="menu">
        <header>
            <h1>Alpha</h1>
        </header>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="registrazione.php" class="<?php echo (isset($_SESSION['nickname'])) ? 'disabilitata' : ''; ?>">Registrazione</a></li><!--SE L'UTENTE è AUTENTICATO LA FUNZIONA E' STATA DISABILITATA-->
                <li><a href="login.php" class="<?php echo (isset($_SESSION['nickname'])) ? 'disabilitata' : ''; ?>">Login</a></li><!--SE L'UTENTE è AUTENTICATO LA FUNZIONA E' STATA DISABILITATA-->
                <li><a href="bacheca.php" class="<?php echo (isset($_SESSION['nickname'])) ? '' : 'disabilitata'; ?>">Bacheca</a></li>
                <li><a href="scrivi.php" class="<?php echo (isset($_SESSION['nickname'])) ? '' : 'disabilitata'; ?>">Scrivi</a></li>
                <li><a href="scopri.php" >Scopri</a></li>
                <li><a href="logout.php" class="<?php echo (isset($_SESSION['nickname'])) ? '' : 'disabilitata'; ?>" onclick="return confirmLOGOUT()">Logout</a></li><!--chiedo conferma per il LOGOUT-->
            </ul>
            </div>
        </nav>
        </div class="menu">                
        <?php
        include 'ultimoTweet.php';//INCLUDO L'ULTIMO TWEET IN ALTO SE DISPONIBILE
        ?>
            <script>
            function confirmLOGOUT() {
                if (confirm("Sei sicuro di voler fare il LOGOUT?")) 
                {
                        window.location.href = "logout.php";
                    } else {
                        return false;
                    }
                }
        </script>
        <main>