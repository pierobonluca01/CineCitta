<?php

use template\Template;

require_once("./template/template.php");

$page = new Template("error");
$page->replaceValue("Errore", "500");
$page->replaceValue("Descrizione", "Errore del server.");
$page->replaceValue("Quote", "Sembra che il nostro server abbia deciso di prendersi una pausa caffè. Ci scusiamo per l'inconveniente.");
$page->replaceTag("FOOTER", new Template("../component/html/footer"));

echo $page;

?>