<?php
if(session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}
$percorso = $_SERVER['PHP_SELF'];
$nome_pagina = basename($percorso);


//inizializzo booleani controlli
$controlloNome = false;
$controlloCognome = false;
$controlloNascita = false;
$controlloIndirizzo = false;
$controlloNick = false;
$controllo1 = false;
$controllo2 = false;
$controllo3 = false;
$controllo4 = false;
$controllo5 = false;
$controlloUsernameEsistente = false;
$inserimentoAvvenuto = false;
include 'header.php';
//VERIFICO I DATI TRAMITE PAGINA DI VALIDAZIONE LATO SERVER PERCHE' E' MOLTO PIU' SICURO
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    include 'validatore.php';
}
?>

<div class="content">
        <img src="IMMAGINI/simbolo.png" alt="Simbolo">
        <div class="Registrazione">
            <h2>Crea il tuo Account</h2>
            <p class="reg">Inserisci i dati</p>
            <form name="registrazione" method="POST"  onsubmit ="return validateForm()"action=#><!--il form manda i dati alla funzione JS per verificare i dati anche lato client per minimizzare il lavoro del server-->
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" required><br>
                <?php
                if ($controlloNome == true)
                {
                    echo ("<div class='Errore'><p>Il nome deve essere una stringa di minimo 2 e massimo 12 caratteri, con solo lettere ed il carattere spazio come caratteri accettabili e deve necessariamente iniziare con una lettera maiuscola</p></div>");
                }
                ?>
                <label for="surname">Cognome:</label>
                <input type="text" id="surname" name="surname" required><br>
                <?php
                if ($controlloCognome == true)
                {
                    echo ("<div class='Errore'><p>Il cognome deve iniziare con una lettera maiuscola e contenere solo lettere e spazi, con una lunghezza minima di 2 e massima di 16 caratteri</p></div>");
                }
                ?>
                <label for="birthdate">Data di nascita:</label>
                <input type="text" id="birthdate" name="birthdate" required><br>
                <?php
                if ($controlloNascita == true)
                {
                    echo ("<div class='Errore'><p>La data di nascita deve essere nel formato aaaa-mm-gg, con sia i mesi ed i giorni che possono omettere lo zero iniziale</p></div>");
                }
                ?>
                <label for="address">Indirizzo:</label>
                <input type="text" id="address" name="address" required><br>
                <?php
                if ($controlloIndirizzo == true)
                {
                    echo ("<div class='Errore'><p>L'indirizzo deve essere nel formato 'Via/Corso/Largo/Piazza/Vicolo nome numeroCivico', dove 'nome' può contenere solo lettere e spazi, e 'numeroCivico' è un numero da 1 a 4 cifre.</p></div>");
                }
                ?>
                <label for="username">Username:</label>
                <input type="text" id="nick" name="nick" required><br>
                <?php
                if ($controlloNick == true)
                {
                    echo ("<div class='Errore'><p>L'username deve essere lungo da 4 a 10 caratteri, può contenere solo lettere, numeri, '-' o '_', e deve iniziare con un carattere alfabetico.</p></div>");
                }
                ?>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <?php
                if ($controllo1 == true)
                {
                    echo ("<div class='Errore'><p>La password deve essere lunga da 8 a 16 caratteri.</p></div>");
                }
                ?>
                <?php
                if ($controllo2 == true)
                {
                    echo ("<div class='Errore'><p>La password deve contenere almeno 1 lettera Maiuscola.</p></div>");
                }
                ?>
                <?php
                if ($controllo3 == true)
                {
                    echo ("<div class='Errore'><p>La password deve contenere almeno 1 lettera Minuscola.</p></div>");
                }
                ?>
                <?php
                if ($controllo4 == true)
                {
                    echo ("<div class='Errore'><p>La password deve contenere almeno 2 numeri.</p></div>");
                }
                ?>
                <?php
                if ($controllo5 == true)
                {
                    echo ("<div class='Errore'><p>La password deve contenere almeno 2 caratteri speciali tra i seguenti: #!?@%^&*+=</p></div>");
                }
                ?>

                <input type="submit" id ="bottone"value="Iscriviti" class="btn">
                <?php
                    if ($controlloUsernameEsistente == true)
                    {
                        echo ("<div class='Errore'><p>Username già presente nel database. Riprova con un altro</p></div>");
                    }
                ?>
                <?php
                    if ($inserimentoAvvenuto == true)
                    {
                        echo ("<p>Caro $nome i dati da lei inseriti sono corretti, Benvento tra di noi</p>");
                        echo ("<p><a href='login.php'>Effettua il login per cominciare</p></a>");
                    }
                ?>
            </form>
        </div>
        
    </div>
<?php
include 'footer.php';
?>
