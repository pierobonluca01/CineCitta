<?php

use template\Template;

require_once("./template/template.php");

$page = new Template("error");
$page->replaceValue("Errore", "404");
$page->replaceValue("Descrizione", "La pagina non è stata trovata.");
$page->replaceValue("Quote", "<q>Pagine?! Dove stiamo andando non c'è bisogno di pagine!</q> - semicit. Doc");
$page->replaceTag("FOOTER", new Template("../component/html/footer"));

echo $page;

?>