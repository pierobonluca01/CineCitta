<?php

use model\Database;
require_once("./model/db.php");

session_start();
setlocale(LC_ALL, "it_IT");
header("Cache-Control: max-age=2592000");

if(isset($_SESSION["connection"])) {
    try {
        $_SESSION["connection"]->connect();
        $_SESSION["connection"]->disconnect();
    } catch(Exception $e) {
        echo "<a href=\"logout.php\">Le credenziali del database sono state modificate, esegui il logout per ripristinare la connessione al database dopo aver sistemato le credenziali.</a>";
    }
}

if(!isset($_SESSION["connection"])) {
    $_SESSION["connection"] = new Database(
        "127.0.0.1",
        "lpierobo",
        "lpierobo", //psw
        "lpierobo"
    );
}

?>