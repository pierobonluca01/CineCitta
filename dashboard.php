<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use dashboard\Settings;
use dashboard\Bookings;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/dashboard/settings.component.php");
require_once("./template/component/dashboard/bookings.component.php");

require_once("./model/connection.php");
require_once("./model/auth.php");

$page = new Template("dashboard");
$page->replaceTag("SUBTITLE", "Dashboard");
$page->replaceTag("TOPBAR", new Topbar("dashboard"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Area personale", "#")
);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceValue("Username", $_SESSION["username"]);
$page->replaceTag("BOOKINGS", new Bookings);
$page->replaceTag("SETTINGS", new Settings);
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>