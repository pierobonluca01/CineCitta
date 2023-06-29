<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use session\Login;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/session/login.component.php");

require_once("./model/connection.php");

$page = new Template("session");
$page->replaceValue("Robots", "all");
$page->replaceTag("SUBTITLE", "Login");
$page->replaceTag("TOPBAR", new Topbar("login"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Login", "#", "en")
);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("SESSION", new Login);
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>