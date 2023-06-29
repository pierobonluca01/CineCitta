<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use book\ScreenForm;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/book/screenForm.component.php");

require_once("./model/connection.php");
require_once("./model/auth.php");

$page = new Template("book");
$page->replaceTag("SUBTITLE", "Prenota");
$page->replaceTag("TOPBAR", new Topbar);
if(isset($_GET["code"])) {
    $page->replaceValue("Heading", "Prenotazione");
    $breadcrumb=array(
        new BreadcrumbElement("Home", "index.php", "en"),
        new BreadcrumbElement("Area personale", "dashboard.php"),
        new BreadcrumbElement("Prenotazione", "#")
    );
} else {
    $page->replaceValue("Heading", "Prenota");
    $breadcrumb=array(
        new BreadcrumbElement("Home", "index.php", "en"),
        new BreadcrumbElement("Proiezioni", "screenings.php"),
        new BreadcrumbElement("Prenota", "#")
    );
}
$page->replaceTag("BOOK", new ScreenForm);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>