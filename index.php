<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use home\Home;
use home\Trending;
use home\Today;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/home/home.php");
require_once("./template/component/home/trending.component.php");
require_once("./template/component/home/today.component.php");

require_once("./model/connection.php");

$page = new Template("index");
$page->replaceTag("SUBTITLE", "Home");
$page->replaceTag("TOPBAR", new Topbar("index"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "#", "en")
);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("TRENDING", new Trending);
$page->replaceTag("TODAY", new Today);
$page->replaceTag("INTRO", new Home("intro"));
$page->replaceTag("TECH", new Home("tech"));
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>