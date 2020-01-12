<?php

// Exemple de connexió a diferents tipus de bases de dades.
# Connectem a la base de dades

$host = 'localhost';
$user = 'jsapena';
$pass = 'jsapena';
$dbname = 'futbolshop';


try {

    $pdo = new PDO ( "mysql:host=$host;dbname=$dbname;charset=utf8", $user,$pass);



    #Perquè generi excepcions a l'hora de reportar errors.
    $pdo->setAttribute (PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


}
catch (PDOException $e) {
    echo $e-> getMessage ();
}

// Si tot va bé en $ pdo tindrem el objecte que gestionarà la connexió amb la base de dades.