<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

include 'CONFIGURAZIONE/confignNormale.php';

$username = "";
$ultimo ="";
$controlloNoTweet = false;

if(isset($_SESSION['nickname']))
{
    $username = trim($_SESSION['nickname']);//richiamo l'username di sessione
    mysqli_set_charset($conn, "utf8");//UTILIZZO CODIFICA PER DATI NON ASCII A 7 BIT

    //PRENDO L'ULTIMO TWEET DELL'UTENTE SE DISPONIBILE CON LE PREPARED STATEMENT
    $sql = "SELECT testo FROM tweets WHERE username = ? ORDER BY data DESC LIMIT 1";
    $stmt = mysqli_prepare( $conn, $sql );
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute( $stmt );
    mysqli_stmt_store_result($stmt); 
    mysqli_stmt_bind_result($stmt, $testo );
    if (mysqli_stmt_num_rows($stmt) > 0) 
    {
        if (mysqli_stmt_fetch($stmt)) {
            $tweet = $testo;
            $ultimo = substr($tweet, 0, 30);
        }
    }
    else{
        $controlloNoTweet = true;
    }
        mysqli_stmt_close( $stmt );
}

if ($username !="" && !$controlloNoTweet) {//SE L'USERNAME E' DIVERSO DA UNA STRINGA VUOTA E SONO PRESENTI ALMENO 1 TWEET DELL'UTENTE ALLORA FAI:
    echo('<div class="ultimoTweet"><div class="username">'.$username.'</div>
    <p class="testoTweet">'.$ultimo.'</p></div>');
}
?>