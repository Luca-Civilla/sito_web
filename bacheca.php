<?php
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}

// VERIFICO SE L'UTENTE NON E' AUTENTICATO E LO REINDIRIZZO A PAGINA SCOPRI
if (!isset($_SESSION['nickname']) ) 
{
    $_SESSION['errore'] = "Identità non verificata! Devi prima autenticarti per utilizzare questa funzione. Sei stato reindirizzato alla pagina Scopri";
    header("Location: scopri.php");
    exit();
}

include 'CONFIGURAZIONE/confignNormale.php';

// PER GESTIRE L'USERNAME LOGGATO
if(isset($_SESSION['nickname']))
{
    $username_generale = trim($_SESSION['nickname']);
}
$percorso = $_SERVER['PHP_SELF'];
$nome_pagina = basename($percorso);

// PRENDO I TWEET 

//EFFETTUO CONTROLLI SU DATE E LE INSERISCO NELLA QUERY
$dataInizio = "";
$dataFine ="";
$controlloFiltro = false;
if ($_SERVER["REQUEST_METHOD"] == "GET")
{
    $dataInizio = $_GET["start"];
    $dataFine = $_GET["end"];

}

if ($dataInizio!="" and $dataFine!="")
{
    $query = "SELECT * FROM tweets WHERE username=? AND data BETWEEN ? AND ? ORDER BY data DESC";
    $stmt = mysqli_prepare($conn, $query);//USO QUERY PREPARED STATEMENT PER EVIARE ATTACCHI 
    mysqli_stmt_bind_param($stmt, "sss", $username_generale,$dataInizio,$dataFine);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt); 

    mysqli_stmt_bind_result($stmt, $nickname, $data, $testo);
    $controlloFiltro = true;//-->SE FILTRO ATTIVO ALLORA NON SI DEVE STAMPARE L'INVITO A SCRIVERE NUOVI TWEET

}
else
{
    $query = "SELECT * FROM tweets WHERE username=? ORDER BY data DESC";
    $stmt = mysqli_prepare($conn, $query);//USO QUERY PREPARED STATEMENT
    mysqli_stmt_bind_param($stmt, "s", $username_generale);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt); 
    mysqli_stmt_bind_result($stmt, $nickname, $data, $testo);
}


$tweets = [];
$niente = False; // SE NON HA TWEET INVITO UTENTE A FARLO

if (mysqli_stmt_num_rows($stmt) > 0) 
{
    while (mysqli_stmt_fetch($stmt)) 
    {
        $tweets[] = array('nickname' => $nickname, 'data' => $data, 'testo' => $testo);
    }
    
} else 
{
    $niente = True;//SETTO CONTROLLO PER INVITARE UTENTE A SCRIVERE UN NUOVO TWEET
}
mysqli_stmt_close($stmt);

include 'header.php';


//CREO IL FORM PER FILTRARE L'INTERVALLO TEMPORALE
?>
<h2 class="dopoLogin">Bacheca</h2>
<div class="contenitore">
<form id="PERIODO" method="GET" action=#>
    <label for="inizio">Da:</label>
    <input type="date" id="start" name="start" value="<?php echo $start_date; //in questo modo rendo più dinamica la pagina?>">
    <label for="fine">A:</label>
    <input type="date" id="end" name="end" value="<?php echo $end_date; ?>">
    <button id="btnPeriodo" type="submit" class="btnFiltra">Filtra</button>
</form>

<?php
if($niente && !$controlloFiltro)
{//VISUALIZZA QUELLO CHE VEDE L'UTENTE AL PRIMO ACCESSO
    echo "<div class ='tweet'><p>Non hai scritto ancora nessun tweet. Inizia adesso</p></div>";
    echo "<button class='btnFiltra' onclick='window.location.href =\"scrivi.php\"'>Scrivi</button>";
} 
else {
    foreach ($tweets as $tweet) {
        echo "<div class ='tweet'>
        <div class = 'utente'>" . $tweet['nickname'] . " - " . $tweet['data'] . "</div>
        <p>" . $tweet['testo'] . "</p>
        </div>";
    }

}
echo "</div>";
include 'footer.php';
?>