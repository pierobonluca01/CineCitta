<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use session\DeleteConfirm;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/session/deleteConfirm.component.php");

require_once("./model/connection.php");
require_once("./model/auth.php");

$page = new Template("session");
$page->replaceValue("Robots", "noindex");
$page->replaceTag("SUBTITLE", "Eliminazione utente");
$page->replaceTag("TOPBAR", new Topbar);
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Area personale", "dashboard.php"),
    new BreadcrumbElement("Eliminazione utente", "#")
);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("SESSION", new DeleteConfirm);
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>