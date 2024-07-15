<?php
    $nome = trim($_POST["name"]);
    $cognome = trim($_POST["surname"]);
    $nascita = trim($_POST["birthdate"]);
    $indirizzo = trim($_POST["address"]);
    $user = trim($_POST["nick"]); 
    $pass = trim($_POST["password"]);
    

    //VERIFICO VALIDITA' DATI LATO SERVER
    $errori = [];
    if (!preg_match("/^[A-Z][a-zA-Z\s]{1,11}$/", $nome))
    {
        $controlloNome = true; 
    }
    if (!preg_match("/^[A-Z][a-zA-Z\s]{1,15}$/", $cognome))
    {
        $controlloCognome = true; 
    }
    if (!preg_match("/^\d{4}-(0?[1-9]|1[012])-(0?[1-9]|[12][0-9]|3[01])$/", $nascita))
    {
        $controlloNascita = true;
    }
    if (!preg_match("/^(Via|Corso|Largo|Piazza|Vicolo) [a-zA-Z\s]+ \d{1,4}$/", $indirizzo))
    {
        $controlloIndirizzo = true;
    }

    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9\-_]{3,9}$/", $user))
    {
        $controlloNick = true;
    }
    //EFFETTUO DIVERSI CONTROLLI SULLA PASSWORD, PERCHE' ESSENDO NASCOSTA L'UTENTE PUO' NON TROVARE L'ERRORE
        // Controllo lunghezza
    if (strlen($pass) < 8 || strlen($pass) > 16) {
        $controllo1 = true;
    }

    // Almeno 1 lettera maiuscola
    if (!preg_match('/[A-Z]/', $pass)) 
    {
        $controllo2 = true;
    }

    // Almeno 1 lettera minuscola
    if (!preg_match('/[a-z]/', $pass)) {
        $controllo3 = true;
    }

    // Almeno 2 numeri
    if (!preg_match('/\d.*\d/', $pass)) {//USO L'* DOPO LA 1 SEQUENZA PER INDICARE 0 O AL PIU' RIPETIZIONI
        $controllo4 = true;
    }

    // Almeno 2 caratteri speciali
    if (!preg_match('/[#!?@%^&*+=].*[#!?@%^&*+=]/', $pass)) 
    {
        $controllo5 = true;
    }

//SE TUTTI I CONTROLLI VENGONO SUPERATI VERIFICO SE PUO' ESSERE AGGUNTO AL DATABASE

    if (!$controlloNome && !$controlloCognome && !$controlloNascita && !$controlloIndirizzo && !$controlloNick && !$controllo1 && !$controllo2 && !$controllo3 && !$controllo4 && !$controllo5)
    {
        // Verifico  se l'utente esiste già nel database
        include 'CONFIGURAZIONE/configPrivilegiato.php';


        $sql = "SELECT username 
                        FROM utenti WHERE username = '$user'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {//SE ESISTONO GIA UTENTI CON QUELL'USERNAME:
            $controlloUsernameEsistente = true;
            mysqli_close( $conn );

        } 
        else //SE NON ESISTE ALLORA POSSO AGGIUNGERLO AL DATABASE
        {
            $sql1 = "INSERT INTO utenti (nome, cognome, data, indirizzo, username, pwd)
                    VALUES ('$nome', '$cognome', '$nascita', '$indirizzo', '$user', '$pass')";

            if (mysqli_query($conn, $sql1) === true) 
            {
                $inserimentoAvvenuto = true;
                mysqli_close( $conn );    
            } 
        }
    }

?>