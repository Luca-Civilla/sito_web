<?php //vedo se la sessione esiste altrimenti la inizializzo
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

$percorso = $_SERVER['PHP_SELF'];
$nome_pagina = basename($percorso);

include 'CONFIGURAZIONE/confignNormale.php';

$sbagliato = False;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $user_form = trim($_POST['username']);
    $pwd_form = trim($_POST['password']);
    $query = "SELECT pwd FROM utenti WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);//CREO LA PREPARED STATEMENT PER EVITARE ATTACCHI DI TIPO SQL INJECTION
    mysqli_stmt_bind_param($stmt, "s", $user_form);
    mysqli_stmt_execute($stmt);
    $pwd_giusta = ""; // così se la query non resituisce nulla ho un valore che non dà errore
    mysqli_stmt_bind_result($stmt, $pwd_giusta);
    mysqli_stmt_fetch($stmt);
    
    
    if($pwd_form == $pwd_giusta){   // se password giusta setto il cookie ed indirizzo in bacheca
        $scadenza = time() + 3600*16; //scadenza 16 ore
        setcookie('nickname', $user_form, $scadenza,'/');
        $_SESSION['nickname'] = $user_form;//SALVO NELLA SESSIONE L'USERNAME
        mysqli_stmt_close($stmt);
        header('Location: bacheca.php');
        exit();//ESCO DALLA PAGINA DOPO AVER DATO UN HEADER
    } else {
        $sbagliato = True;//SETTO IL CONTROLLO CHE RICHIAMO NEL LOGIN PER DIRE CHE PASSWORD O USERNAME SONO ERRATI
        mysqli_stmt_close($stmt);
    }
}
include 'header.php';
?>
<div class="content">
<img src="IMMAGINI/simbolo.png" alt="Simbolo">
<div class="login">
    <h2>Effettua il Login</h2>
    <p>Bentornato, inserisci le tue credenziali</p>
    <form name="faiLogin" method="POST" action=#>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php if(isset($_COOKIE['nickname'])){ echo $_COOKIE['nickname']; }else{ echo "";}//IMPOSTO L'ULTIMO USERNAME SE PRESENTE ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" id="bottone1"value="Accedi" class="btn">
        <input type="reset" id="bottone2" value="Cancella"class="btn">
        <?php // se sbagliata validazione parte l'errore visuabilizzabile correttamente tramite il css
        if($sbagliato)
        {
            echo "<div class='Errore'><p>Username e/o Password errati. Riprova l'autenticazione</p></div>";
        }
        ?>
    </form>
    <button id="btn" type="button" onclick="NoLogin()"  class="btn">Continua senza autenticarti</button>
    <script>//tramite js reindirizzo l'utente alla pagina scopri, prima chiedo se effettivamente vuole andare su quella pagina
    function NoLogin() 
    {
        window.alert("Continuare senza autenticazione?");
        window.location.href = "scopri.php";;
    }
    </script>
    </div>
</div>
<?php
include 'footer.php';
?>
