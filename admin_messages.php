<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use admin\Menu;
use admin\Messages;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/admin/menu.component.php");
require_once("./template/component/admin/messages.component.php");

require_once("./model/connection.php");
require_once("./model/auth.php");


$page = new Template("admin_messages");
$page->replaceTag("SUBTITLE", "Messaggi");
$page->replaceTag("TOPBAR", new Topbar("admin"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Area di amministrazione", "admin.php"),
    new BreadcrumbElement("Messaggi", "#")
);
$menu = new Menu("admin_messages");
if(!$menu->isAdmin($_SESSION["username"])) {
    header("Location: login.php");
}
$page->replaceTag("MENU", $menu);
$page->replaceTag("MESSAGES", new Messages);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>