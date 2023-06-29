<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use contacts\Contacts;
use contacts\Form;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/dashboard/settings.component.php");
require_once("./template/component/dashboard/bookings.component.php");
require_once("./template/component/contacts/contacts.php");
require_once("./template/component/contacts/form.component.php");

require_once("./model/connection.php");

$page = new Template("contacts");
$page->replaceTag("SUBTITLE", "Contatti");
$page->replaceTag("TOPBAR", new Topbar("contacts"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Contatti", "#")
);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("CONTATTI", new Contacts("contacts"));
$page->replaceTag("FORM", new Form);
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>