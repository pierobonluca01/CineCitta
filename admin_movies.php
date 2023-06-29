<?php

use template\Template;
use component\Topbar;
use component\Breadcrumb;
use component\BreadcrumbElement;
use component\Component;
use admin\Menu;
use admin\InsertMovie;
use admin\EditMovie;

require_once("./template/template.php");
require_once("./template/component/topbar.component.php");
require_once("./template/component/breadcrumb.component.php");
require_once("./template/component/admin/menu.component.php");
require_once("./template/component/admin/insertMovie.component.php");
require_once("./template/component/admin/editMovie.component.php");

require_once("./model/connection.php");
require_once("./model/auth.php");


$page = new Template("admin_movies");
$page->replaceTag("SUBTITLE", "Gestione film");
$page->replaceTag("TOPBAR", new Topbar("admin"));
$breadcrumb=array(
    new BreadcrumbElement("Home", "index.php", "en"),
    new BreadcrumbElement("Area di amministrazione", "admin.php"),
    new BreadcrumbElement("Gestione film", "#")
);
$menu = new Menu("admin_movies");
if(!$menu->isAdmin($_SESSION["username"])) {
    header("Location: login.php");
}
$page->replaceTag("MENU", $menu);
$page->replaceTag("INSERT", new InsertMovie);
$page->replaceTag("EDIT", new EditMovie);
$page->replaceTag("BREADCRUMB", new Breadcrumb($breadcrumb));
$page->replaceTag("FOOTER", new Component("footer"));

echo $page;

?>