<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use admin\Menu;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/admin/menu.component.php");

require_once("./model/connection.php");
require_once("./model/auth.php");


$page = new Template("admin");
$page->replaceTag("SUBTITLE", "Area di amministrazione");
$page->replaceTag("TOPBAR", new Topbar("admin"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Area di amministrazione", "#")
);
$menu = new Menu("admin");
if(!$menu->isAdmin($_SESSION["username"])) {
    header("Location: login.php");
}
$page->replaceTag("MENU", $menu);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>