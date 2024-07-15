<?php
$serverName = 'localhost';
$username = 'normale';
$password = 'posso_leggere?';
$database = 'social_network';

//CREO CONNESSIONE
$conn = mysqli_connect($serverName, $username, $password, $database);

//USO CODIFICA UTF-8 PEER LA CORRETTA VISUALIZZAZIONE DI TUTTI I DATI
mysqli_set_charset($conn,"utf8");

//CONTROLLO CHE VENGA STABILITA LA CONNESSIONE
if(mysqli_connect_error()){
    echo "Connessione fallita: ". mysqli_connect_error();
}
?>