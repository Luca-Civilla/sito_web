<?php
if(session_status() !== PHP_SESSION_ACTIVE)
{
    session_start();
}

// VERIFICO SE L'UTENTE NON è GIA' AUTENTICATO
if (!isset($_SESSION['nickname']) ) 
{
    $_SESSION['errore'] = "Identità non verificata! Devi prima autenticarti per utilizzare questa funzione. Sei stato reindirizzato alla pagina Scopri";
    header("Location: scopri.php");
    exit();
}

// PER GESTIRE L'USERNAME LOGGATO
if(isset($_SESSION['nickname'])){
    $username_generale = $_SESSION['nickname'];
}
$percorso = $_SERVER['PHP_SELF'];
$nome_pagina = basename($percorso);
$lunga = False; // PER L'ERRORE DELLA LUNGHEZZA
$vuota = False;//PER L'ERRORE DELLA STRINGA VUOTA 


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $username_generale;
    $data = date("Y-m-d H:i:s");
    $testo = $_POST['testo'];
    //EFFETTUARE CONTROLLO 140 CARATTERI NEL CASO INSERISCO
    $pattern = "/^.{1,140}$/"; // Pattern per una stringa alfanumerica con lunghezza da 1 a 140 caratteri dove chiedo solo che la lunghezza sia quella
    if ($testo == "")
    {
        $vuota = True;
    } elseif (preg_match($pattern, $testo)) 
    {
        include 'CONFIGURAZIONE/configPrivilegiato.php';
        $query = "INSERT INTO tweets (username, data, testo) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);//CREO LA PREPARED STATEMENT PER EVITARE ATTACCHI DI TIPO SQL INJECTION
        mysqli_stmt_bind_param($stmt, "sss", $user, $data, $testo);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close( $stmt);
        mysqli_close( $conn );
        header('Location: bacheca.php');
        exit();//ESCO DALLA PAGINA DOPO AVER DATO UN HEADER

    } else {
        $lunga = True;
    }
    
}

include 'header.php';
?>
<form class="formScrivi"name='scrivi' method='POST' action=#>
    <label for="testo">Scrivi qualcosa:</label>
    <textarea id='textarea' name='testo' rows="5" id='testo'></textarea>
    <button type='submit' id ="botton">Invia</button>
</form>

<?php
if($vuota){
    echo "<div class='Errore'><p>Inserire del testo.</p></div>";
} elseif($lunga){
    echo "<div class='Errore'><p>Il testo inserito può essere lungo al massimo 140 caratteri.</p></div>";
}

include 'footer.php';
?>