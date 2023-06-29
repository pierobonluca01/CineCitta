<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use screenings\Calendar;
use screenings\Schedule;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/screenings/calendar.component.php");
require_once("./template/component/screenings/schedule.component.php");

require_once("./model/connection.php");

$page = new Template("screenings");
$page->replaceTag("SUBTITLE", "Proiezioni");
$page->replaceTag("TOPBAR", new Topbar("screenings"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Proiezioni", "#")
);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("CALENDAR", new Calendar);
if(isset($_GET["date"]))
    $page->replaceTag("SCHEDULE", new Schedule);
else
$page->replaceTag("SCHEDULE", "");
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>